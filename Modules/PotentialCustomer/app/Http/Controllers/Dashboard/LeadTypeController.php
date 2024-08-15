<?php

namespace Modules\PotentialCustomer\app\Http\Controllers\Dashboard;

use app\Helpers\Helpers;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Nwidart\Modules\Routing\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Modules\PotentialCustomer\app\Models\LeadType;
use Modules\PotentialCustomer\app\Models\LeadAccount;
use Modules\PotentialCustomer\app\Exports\DataTableExport;
use Modules\PotentialCustomer\app\Exports\LeadFilterExport;
use Modules\PotentialCustomer\app\DataTables\LeadTypeDataTable;
use Modules\PotentialCustomer\app\Http\Requests\LeadTypeRequest;

class LeadTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LeadTypeDataTable $dataTable)
    {
        return $dataTable->render('potentialcustomer::pages.leads.lead_type.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('potentialcustomer::pages.leads.lead_type.create_edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LeadTypeRequest $request)
    {
        LeadType::create([
            'title'=> $request->title,
            'description' => $request->description,
            'status'=> $request->status,
            'created_by' =>auth()->id(),
        ]);
        Alert::success(__('Success'),__('Lead Type Created Successfully'));
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(LeadType $leadType)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeadType $leadType)
    {
        return view('potentialcustomer::pages.leads.lead_type.create_edit',compact('leadType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LeadType $leadType)
    {

        $leadType->update([
            'title' => $request->title,
            'description'=> $request->description,
            'status'=> $request->status,
            'updated_by'=> auth()->id()
        ]);

        Alert::success(__('Success'),__('Lead Type Edited Successfully'));
        return redirect()->route('lead_type.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeadType $leadType)
    {

        $leadType->update([
            'deleted_by' => auth()->id(),
        ]);
        $leadType->delete();
        Alert::success(__('Success'),__('Lead Type Deleted Successfully'));
    }

    public function export(Request $request)
    {
        if (empty($request->SelectedRows)) {
            $leadTypes = LeadType::where('created_by', auth()->id())->get();
        } else {
            $leadTypes = LeadType::whereIn('id', explode(',', $request->SelectedRows))->get();
        }

        $selectedColumns = explode(',', $request->selectedColumns);
        $columns = [];
        foreach ($selectedColumns as $column) {
            $columns[] = str_replace(' ', '_', strtolower($column));
        }

        return Helpers::exportFileSettings($request->exportFormat,'lead_types',$leadTypes,$columns);

    }
}
