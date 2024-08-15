<?php
namespace Modules\PotentialCustomer\app\Http\Controllers\Dashboard;

use App\Models\User ;
use app\Helpers\Helpers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Nwidart\Modules\Routing\Controller;
use Modules\PotentialCustomer\app\DataTables\SalesAgentsDataTable;

class SalesAgentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SalesAgentsDataTable $dataTable)
    {
        return $dataTable->render('potentialcustomer::pages.sales-target.sales_agent.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $salesAgent)
    {
        $salesTargets = $salesAgent->salesTargets()->paginate(1);

        return view('potentialcustomer::pages.sales-target.sales_agent.show', compact('salesAgent', 'salesTargets'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $salesAgent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $salesAgent)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $salesAgent)
    {
        abort(404);
    }


    public function export(Request $request)
    {
        $roleId = DB::table('model_has_roles')
        ->select('model_id')
        ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
        ->where('roles.name', 'sales');
        
        if (empty($request->SelectedRows)) {
            $salesAgents = User::where('created_by', auth()->id())->whereIn('id', $roleId)->get();

        } else {
            $salesAgents = User::whereIn('id', explode(',', $request->SelectedRows))->get();
        }

        $selectedColumns = explode(',', $request->selectedColumns);
        $columns = [];
        foreach ($selectedColumns as $column) {
            $columns[] = str_replace(' ', '_', strtolower($column));
        }

        return Helpers::exportFileSettings($request->exportFormat,'sales_agents',$salesAgents,$columns);

    }
}
