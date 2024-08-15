<?php

namespace Modules\PotentialCustomer\app\Http\Controllers\Dashboard;

use app\Helpers\Helpers;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Nwidart\Modules\Routing\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Modules\PotentialCustomer\app\Models\LeadValue;
use Modules\PotentialCustomer\app\Exports\LeadFilterExport;
use Modules\PotentialCustomer\app\DataTables\LeadValueDataTable;
use Modules\PotentialCustomer\app\Http\Requests\LeadValueRequest;

class LeadValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LeadValueDataTable  $dataTable)
    {
        return $dataTable->render('potentialcustomer::pages.leads.lead_value.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('potentialcustomer::pages.leads.lead_value.create_edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LeadValueRequest $request)
    {
        LeadValue::create([
            'title'=> $request->title,
            'description' => $request->description,
            'status'=> $request->status,
            'created_by' =>auth()->id(),
        ]);
        Alert::success(__('Success'),__('Lead Value Created Successfully'));
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(LeadValue $leadValue)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeadValue $leadValue)
    {
        return view('potentialcustomer::pages.leads.lead_value.create_edit',compact('leadValue'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LeadValueRequest $request, LeadValue $leadValue)
    {
        $leadValue->update([
            'title'=> $request->title,
            'description'=> $request->description,
            'status'=> $request->status,
            'updated_by'=> auth()->id(),

        ]);
        Alert::success(__('Success'),__('Lead Value Edited Successfully'));
        return redirect()->route('lead_value.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeadValue $leadValue)
    {
        $leadValue->update([
            'deleted_by' => auth()->id()
        ]);
        $leadValue->delete();
        Alert::success(__('Success'),__('Lead Value Deleted Successfully'));

    }

    public function export(Request $request)
    {
        if (empty($request->SelectedRows)) {
            $leadValues = LeadValue::where('created_by', auth()->id())->get();
        } else {
            $leadValues = LeadValue::whereIn('id', explode(',', $request->SelectedRows))->get();
        }

        $selectedColumns = explode(',', $request->selectedColumns);
        $columns = [];
        foreach ($selectedColumns as $column) {
            $columns[] = str_replace(' ', '_', strtolower($column));
        }

        return Helpers::exportFileSettings($request->exportFormat,'lead_values',$leadValues,$columns);

    }
}
