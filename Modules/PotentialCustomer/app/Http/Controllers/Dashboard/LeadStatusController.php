<?php

namespace Modules\PotentialCustomer\app\Http\Controllers\Dashboard;

use app\Helpers\Helpers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Nwidart\Modules\Routing\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Modules\PotentialCustomer\app\Models\LeadStatus;
use Modules\PotentialCustomer\app\Models\LeadAccount;
use Modules\PotentialCustomer\app\Exports\DataTableExport;
use Modules\PotentialCustomer\app\Exports\LeadFilterExport;
use Modules\PotentialCustomer\app\Exports\LeadAccountExport;
use Modules\PotentialCustomer\app\DataTables\LeadStatusDataTable;
use Modules\PotentialCustomer\app\Http\Requests\LeadStatusRequest;

class LeadStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LeadStatusDataTable $dataTable)
    {
        return $dataTable->render('potentialcustomer::pages.leads.lead_status.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('potentialcustomer::pages.leads.lead_status.create_edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LeadStatusRequest $request)
    {
        LeadStatus::create([
            'title'=> $request->title,
            'description' => $request->description,
            'status'=> $request->status,
            'created_by' =>auth()->id(),
        ]);
        Alert::success(__('Success'),__('Lead Status Created Successfully'));
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(LeadStatus $leadStatus)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeadStatus $leadStatus)
    {
        return view('potentialcustomer::pages.leads.lead_status.create_edit',compact('leadStatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LeadStatusRequest $request, LeadStatus $leadStatus)
    {
        $leadStatus->update([
            'title'=> $request-> title,
            'description'=> $request-> description,
            'status'=> $request->status,
            'updated_by'=> auth()->id(),
        ]);
        Alert::success(__('Success'),__('Lead Status Edited Successfully'));
        return redirect()->route('lead_status.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeadStatus $leadStatus)
    {
        $leadStatus->update([
            'deleted_by' => auth()->id()
        ]);
        $leadStatus->delete();
        Alert::success(__('Success'),__('Lead Status Deleted Successfully'));
    }

    public function export(Request $request)
    {
        if (empty($request->SelectedRows)) {
            $leadStatuses = LeadStatus::where('created_by', auth()->id())->get();
        } else {
            $leadStatuses = LeadStatus::whereIn('id', explode(',', $request->SelectedRows))->get();
        }

        $selectedColumns = explode(',', $request->selectedColumns);
        $columns = [];
        foreach ($selectedColumns as $column) {
            $columns[] = str_replace(' ', '_', strtolower($column));
        }

        return Helpers::exportFileSettings($request->exportFormat,'lead_status',$leadStatuses,$columns);

    }
}
