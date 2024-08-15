<?php

namespace Modules\PotentialCustomer\app\Http\Controllers\Dashboard;

use app\Helpers\Helpers;
use Illuminate\Http\Request;
use Nwidart\Modules\Routing\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Modules\PotentialCustomer\app\Models\BrokerType;
use Modules\PotentialCustomer\app\DataTables\BrokerTypesDataTable;
use Modules\PotentialCustomer\app\Http\Requests\BrokerTypeRequest;

class BrokerTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BrokerTypesDataTable $dataTable)
    {
        return $dataTable->render('potentialcustomer::pages.sales-target.broker_type.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('potentialcustomer::pages.sales-target.broker_type.create_edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrokerTypeRequest $request)
    {

        BrokerType::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'created_by' => auth()->id(),
        ]);

        Alert::success(__('Success'), __('Broker Type Created Successfully'));
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(BrokerType $brokerType)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BrokerType $brokerType)
    {
        return view('potentialcustomer::pages.sales-target.broker_type.create_edit',compact('brokerType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrokerTypeRequest $request, BrokerType $brokerType)
    {
        $brokerType->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'updated_by' => auth()->id(),
        ]);
        Alert::success(__('Success'), __('Broker Type Edited Successfully'));
        return redirect()->route('broker_types.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BrokerType $brokerType)
    {
        $brokerType->update([
            'deleted_by' => auth()->id()
        ]);

        $brokerType->delete();
        Alert::success(__('Success'), __('Broker Type Deleted Successfully'));
    }


    public function export(Request $request)
    {
        if (empty($request->SelectedRows)) {
            $brokerTypes = BrokerType::where('created_by', auth()->id())->get();
        } else {
            $brokerTypes = BrokerType::whereIn('id', explode(',', $request->SelectedRows))->get();
        }

        $selectedColumns = explode(',', $request->selectedColumns);
        $columns = [];
        foreach ($selectedColumns as $column) {
            $columns[] = str_replace(' ', '_', strtolower($column));
        }

        return Helpers::exportFileSettings($request->exportFormat,'broker_type',$brokerTypes,$columns);

    }
}
