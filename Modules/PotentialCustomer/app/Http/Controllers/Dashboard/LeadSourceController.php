<?php

namespace Modules\PotentialCustomer\app\Http\Controllers\Dashboard;

use app\Helpers\Helpers;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Nwidart\Modules\Routing\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Modules\PotentialCustomer\app\Models\LeadSource;
use Modules\PotentialCustomer\app\Exports\DataTableExport;
use Modules\PotentialCustomer\app\Exports\LeadFilterExport;
use Modules\PotentialCustomer\app\DataTables\LeadSourceDataTable;
use Modules\PotentialCustomer\app\Http\Requests\LeadSourceRequest;

class LeadSourceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LeadSourceDataTable $dataTable)
    {
        return $dataTable->render('potentialcustomer::pages.leads.lead_source.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('potentialcustomer::pages.leads.lead_source.create_edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LeadSourceRequest $request)
    {
        LeadSource::create([
            'title'=> $request->title,
            'description' => $request->description,
            'status'=> $request->status,
            'created_by' =>auth()->id(),
        ]);
        Alert::success(__('Success'),__('Lead Source Created Successfully'));
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(LeadSource $leadSource)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeadSource $leadSource)
    {
        return view('potentialcustomer::pages.leads.lead_source.create_edit',compact('leadSource'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LeadSourceRequest $request, LeadSource $leadSource)
    {

        $leadSource->update([
            'title' => $request->title,
            'description'=> $request->description,
            'status'=> $request->status,
            'updated_by'=> auth()->id()
        ]);

        Alert::success(__('Success'),__('Lead Source Edited Successfully'));
        return redirect()->route('lead_source.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeadSource $leadSource)
    {
        $leadSource->update([
            'deleted_by' => auth()->id(),
        ]);
        $leadSource->delete();
        Alert::success(__('Success'),__('Lead Source Deleted Successfully'));
    }


    public function export(Request $request)
    {
        if (empty($request->SelectedRows)) {
            $leadSources = LeadSource::where('created_by', auth()->id())->get();
        } else {
            $leadSources = LeadSource::whereIn('id', explode(',', $request->SelectedRows))->get();
        }

        $selectedColumns = explode(',', $request->selectedColumns);
        $columns = [];
        foreach ($selectedColumns as $column) {
            $columns[] = str_replace(' ', '_', strtolower($column));
        }

        return Helpers::exportFileSettings($request->exportFormat,'lead_source',$leadSources,$columns);

    }
}
