<?php

namespace Modules\PotentialCustomer\app\Http\Controllers\Dashboard;

use app\Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Nwidart\Modules\Routing\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Modules\PotentialCustomer\app\Models\Broker;
use Modules\PotentialCustomer\app\Models\BrokerType;
use Modules\PotentialCustomer\app\DataTables\BrokersDataTable;
use Modules\PotentialCustomer\app\Http\Requests\BrokerRequest;

class BrokerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BrokersDataTable $dataTable)
    {
        return $dataTable->render('potentialcustomer::pages.sales-target.broker.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brokerTypes = BrokerType::select('id', 'title')->where('created_by', auth()->id())->where('status', 'active')->get();
        return view('potentialcustomer::pages.sales-target.broker.create_edit', compact('brokerTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrokerRequest $request)
    {
        $image = NULL;
        if ($request->has('image')) {
            $image = Storage::put('brokers/images', $request->image);
        }

        Broker::create([
            'name' => $request->name,
            'image' => $image,
            'email' => $request->email,
            'phone' => $request->phone,
            'broker_type_id' => $request->broker_type_id,
            'status' => $request->status,
            'created_by' => auth()->id(),
        ]);
        Alert::success(__('Success'), __('Broker Created Successfully.'));
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Broker $broker)
    {
        return view('potentialcustomer::pages.sales-target.broker.show', compact('broker'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Broker $broker)
    {
        $brokerTypes = BrokerType::select('id', 'title')->where('created_by', auth()->id())->where('status', 'active')->get();
        return view('potentialcustomer::pages.sales-target.broker.create_edit', compact('broker', 'brokerTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrokerRequest $request, Broker $broker)
    {
        $image = NULL;
        if ($request->has('image')) {
            if ($broker->image) {
                Storage::delete($broker->image);
            }
            $image = Storage::put('brokers/images', $request->image);
        }

        $broker->update([
            'name' => $request->name,
            'image' => $image,
            'email' => $request->email,
            'phone' => $request->phone,
            'broker_type_id' => $request->broker_type_id,
            'status' => $request->status,
            'updated_by' => auth()->id(),
        ]);

        Alert::success(__('Success'), __('Broker Edited Successfully'));
        return redirect()->route('brokers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Broker $broker)
    {
        $broker->update([
            'deleted_by' => auth()->id()
        ]);
        if ($broker->image) {
            Storage::delete($broker->image);
        }
        $broker->delete();
        Alert::success(__('Success'), __('Broker Deleted Successfully'));
    }


    public function export(Request $request)
    {
        if (empty($request->SelectedRows)) {
            $brokers = Broker::where('created_by', auth()->id())->get();
        } else {
            $brokers = Broker::whereIn('id', explode(',', $request->SelectedRows))->get();
        }

        $selectedColumns = explode(',', $request->selectedColumns);
        $columns = [];
        foreach ($selectedColumns as $column) {
            $columns[] = str_replace(' ', '_', strtolower($column));
        }

        return Helpers::exportFileSettings($request->exportFormat,'brokers',$brokers,$columns);

    }
}
