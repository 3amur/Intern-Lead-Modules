<?php

namespace Modules\PotentialCustomer\app\Http\Controllers\Dashboard;

use App\Models\User ;
use app\Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Nwidart\Modules\Routing\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Modules\PotentialCustomer\app\Models\TargetType;
use Modules\PotentialCustomer\app\Models\SalesTarget;
use Modules\PotentialCustomer\app\DataTables\SalesTargetDataTable;
use Modules\PotentialCustomer\app\Http\Requests\SalesTargetRequest;

class SalesTargetController extends Controller
{
    //eager loading to avoid the N+1 query problem
    protected $with = ['salesAgents', 'targetTypes'];
    /**
     * Display a listing of the resource.
     */
    public function index(SalesTargetDataTable $dataTable)
    {
        return $dataTable->render('potentialcustomer::pages.sales-target.sales_targets.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $targetTypes = TargetType::select('id', 'title')->where('created_by', auth()->id())->where('status', 'active')->get();
        $salesAgents = User::select('id', 'name')->where('created_by', auth()->id())->role('sales')->where('status', 'active')->get();
        return view('potentialcustomer::pages.sales-target.sales_targets.create_edit', compact('targetTypes', 'salesAgents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SalesTargetRequest $request)
    {
        try {
            DB::beginTransaction();
            $salesTarget = $this->createSalesTarget($request);
            $salesTarget->targetTypes()->attach($request->target_type_id);
            $salesTarget->salesAgents()->attach($request->sales_agent_id);


            $targetLayers = $request->only([
                'from',
                'to',
                'percentage',
                'layer_target_type_id',
            ]);

            TargetLayerController::createTargetLayers($targetLayers, $salesTarget);

            DB::commit();

            Alert::success(__('Success'), __('Sales Target Created Successfully'));
            return redirect()->back();
        } catch (QueryException $e) {
            DB::rollBack();
            if ($e->getCode() == 23000) {
                return redirect()->back()->withErrors(['sales_agent_id' => 'Duplicate entry found.'])->withInput();
            }
            return redirect()->back()->withErrors(['sales_agent_id' => 'Database error.'])->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['sales_agent_id' => $e->getMessage()])->withInput();
        }
    }

    public function checkExistingTargetOnCreate(Request $request)
    {

        $targetTypeIds = $request->input('target_types');
        $salesAgentIds = $request->input('sales_agents');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        if (isset($targetTypeIds) && isset($salesAgentIds) && isset($startDate) && isset($endDate)) {
            if (strtotime($endDate) >= strtotime($startDate)) {
                $existingTarget = SalesTarget::where(function ($query) use ($salesAgentIds, $targetTypeIds, $startDate, $endDate) {
                    $query->whereHas('salesAgents', function ($query) use ($salesAgentIds) {
                        $query->whereIn('sales_agent_id', $salesAgentIds);
                    })->whereHas('targetTypes', function ($query) use ($targetTypeIds) {
                        $query->whereIn('target_type_id', $targetTypeIds);
                    })->where(function ($query) use ($startDate, $endDate) {
                        $query->where('start_date', '<=', $endDate)
                            ->where('end_date', '>=', $startDate)
                            ->where('status', '=', 'active');
                    });
                })->exists();
                if ($existingTarget && strtotime($endDate) >= strtotime($startDate)) {
                    return response()->json([
                        'success' => false,
                        'error' => 'Targets already exist for the selected criteria.',
                    ]);
                } else {
                    return response()->json([
                        'success' => true
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'error' => 'end date must be after start date'
                ]);
            }
        } else {
            return response()->json([
                'error' => 'make sure that target type, Sales Agent , start date and end date have value and not empty ',
            ]);
        }
    }

    private function createSalesTarget($request)
    {
        return SalesTarget::create([
            'target_name' => $request->target_name,
            'target_value' =>floatval(str_replace(',', '',  $request->target_value)),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'target_calc_method' => $request->target_calc_method,
            'notes' => $request->notes,
            'status' => $request->status,
            'created_by' => auth()->id(),
        ]);
    }



    /**
     * Display the specified resource.
     */
    public function show(SalesTarget $salesTarget)
    {
        $targetTypes = $salesTarget->targetTypes;
        $salesAgents = $salesTarget->salesAgents;
        $targetLayers = $salesTarget->targetLayers;
        return view('potentialcustomer::pages.sales-target.sales_targets.show', compact('targetTypes', 'salesAgents', 'salesTarget', 'targetLayers'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesTarget $salesTarget)
    {
        $targetTypes = TargetType::select('id', 'title')->where('created_by', auth()->id())->where('status', 'active')->get();
        $salesAgents = User::where('created_by', auth()->id())->role('sales')->select('id', 'name')->get();
        return view('potentialcustomer::pages.sales-target.sales_targets.create_edit', compact('targetTypes', 'salesAgents', 'salesTarget'));
    }


    public function checkExistingTargetOnUpdate(Request $request)
    {
        $targetTypeIds = $request->input('target_types');
        $salesAgentIds = $request->input('sales_agents');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $currentTargetId = $request->currentTargetId;

        if (isset($targetTypeIds) && isset($salesAgentIds) && isset($startDate) && isset($endDate)) {
            if (strtotime($endDate) >= strtotime($startDate)) {
                $existingTarget = SalesTarget::where(function ($query) use ($currentTargetId, $salesAgentIds, $targetTypeIds, $startDate, $endDate) {
                    $query->where('id', '<>', $currentTargetId) // Exclude the current target during update
                        ->whereHas('salesAgents', function ($query) use ($salesAgentIds) {
                            $query->whereIn('sales_agent_id', $salesAgentIds);
                        })->whereHas('targetTypes', function ($query) use ($targetTypeIds) {
                            $query->whereIn('target_type_id', $targetTypeIds);
                        })->where(function ($query) use ($startDate, $endDate) {
                            $query->where('start_date', '<=', $endDate)
                                ->where('end_date', '>=', $startDate)
                                ->where('status', '=', 'active');
                        });
                })->exists();

                if ($existingTarget && strtotime($endDate) >= strtotime($startDate)) {
                    return response()->json([
                        'success' => false,
                        'error' => 'Targets already exist for the selected criteria.',
                    ]);
                } else {
                    return response()->json([
                        'success' => true
                    ]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'error' => 'End date must be after start date'
                ]);
            }
        } else {
            return response()->json([
                'error' => 'Make sure that target type, Sales Agent, start date, and end date have a value and are not empty',
            ]);
        }
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(SalesTargetRequest $request, SalesTarget $salesTarget)
    {
        try {
            DB::beginTransaction();
            $this->updateSalesTarget($salesTarget, $request);

            $salesTarget->targetTypes()->detach();
            $salesTarget->targetTypes()->attach($request->target_type_id);
            $salesTarget->salesAgents()->detach();
            $salesTarget->salesAgents()->attach($request->sales_agent_id);

            $targetLayers = $request->only(['from', 'to', 'percentage', 'layer_target_type_id']);
            TargetLayerController::updateTargetLayers($targetLayers, $salesTarget);

            DB::commit();

            Alert::success(__('Success'), __('Sales Target Updated Successfully'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['sales_agent_id' => $e->getMessage()])->withInput();
        }
    }

    private function updateSalesTarget($salesTarget, $request)
    {
        $salesTarget->update([
            'target_name' => $request->target_name,
            'target_value' => floatval(str_replace(',', '',  $request->target_value)),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'target_calc_method' => $request->target_calc_method,
            'notes' => $request->notes,
            'status' => $request->status,
            'updated_by' => auth()->id(),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesTarget $salesTarget)
    {

        $salesTarget->update([
            'deleted_by' => auth()->id(),
        ]);
        $salesTarget->targetTypes()->detach();
        $salesTarget->salesAgents()->detach();
        $salesTarget->targetLayers()->delete();
        $salesTarget->delete();
        Alert::success(__('Success'), __('Sales Target Deleted Successfully'));
    }


    public function export(Request $request)
    {
        if (empty($request->SelectedRows)) {
            $salesTargets = SalesTarget::where('created_by', auth()->id())->get();
        } else {
            $salesTargets = SalesTarget::whereIn('id', explode(',', $request->SelectedRows))->get();
        }

        $selectedColumns = explode(',', $request->selectedColumns);
        $columns = [];
        foreach ($selectedColumns as $column) {
            $columns[] = str_replace(' ', '_', strtolower($column));
        }

        return Helpers::exportFileSettings($request->exportFormat,'sales_targets',$salesTargets,$columns);

    }
}



