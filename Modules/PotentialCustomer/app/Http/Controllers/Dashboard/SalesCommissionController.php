<?php

namespace Modules\PotentialCustomer\app\Http\Controllers\Dashboard;

use App\Models\User ;
use app\Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nwidart\Modules\Routing\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Modules\PotentialCustomer\app\Models\SalesCommission;
use Modules\PotentialCustomer\app\Models\SalesCommissionLayer;
use Modules\PotentialCustomer\app\DataTables\SalesCommissionsDataTable;
use Modules\PotentialCustomer\app\Http\Requests\SalesCommissionRequest;

class SalesCommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SalesCommissionsDataTable $dataTable, User $salesAgent)
    {
        return $dataTable->render('potentialcustomer::pages.sales-target.sales_commission.index', compact('salesAgent'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(User $salesAgent)
    {
        return view('potentialcustomer::pages.sales-target.sales_commission.create_edit', compact('salesAgent'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SalesCommissionRequest $request, User $salesAgent)
    {
        try {
            $amountFrom = $this->sanitizeInput($request->input('amount_from'));
            $amountTo = $this->sanitizeInput($request->input('amount_to'));
            $percent = $this->sanitizeInput($request->input('percent'));

            $validated = $this->validateInput($amountFrom, $amountTo, $percent);

            if (!$validated) {
                Alert::error(__('error'), __("All values must be integers."));
                return redirect()->route('sales_commissions.index',['sales_agent'=>$salesAgent->id]);
            }

            DB::beginTransaction();

            $salesCommission = SalesCommission::create([
                'title' => $request->title,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'notes' => $request->notes,
                'status' => $request->status,
                'sales_agent_id' => $salesAgent->id,
                'created_by' => auth()->id(),
            ]);

            $salesCommissionLayers = [
                'from' => $amountFrom,
                'to' => $amountTo,
                'percentage' => $percent,
            ];

            foreach ($salesCommissionLayers['from'] as $key => $value) {
                SalesCommissionLayer::create([
                    'from' => $salesCommissionLayers['from'][$key],
                    'to' => $salesCommissionLayers['to'][$key],
                    'percentage' => $salesCommissionLayers['percentage'][$key],
                    'sales_commission_id' => $salesCommission->id,
                    'created_by' => auth()->id(),
                ]);
            }

            DB::commit();
            Alert::success(__('success'), __('Commission Created Successfully'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error(__('error'),  __('An error occurred while processing your request.'));
            return redirect()->route('sales_commissions.index',['sales_agent'=>$salesAgent->id]);
        }
    }

    private function sanitizeInput($input)
    {
        if($input){
            return array_map(function ($value) {
                return intval(str_replace(',', '', $value));
            }, $input);
        }

    }

    private function validateInput($amountFrom, $amountTo, $percent)
    {
        foreach ($amountFrom as $key => $value) {
            if (!is_int($amountFrom[$key]) || !is_int($amountTo[$key]) || !is_int($percent[$key])) {
                return false;
            }
        }

        return true;
    }
    /**
     * Display the specified resource.
     */
    public function show(SalesCommission $salesCommission, User $salesAgent)
    {
        return view('potentialcustomer::pages.sales-target.sales_commission.show');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesCommission $salesCommission, User $salesAgent)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SalesCommissionRequest $request, SalesCommission $salesCommission, User $salesAgent)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesCommission $salesCommission, User $salesAgent)
    {
        abort(404);
    }

    public function export(Request $request,User $salesAgent)
    {
        if (empty($request->SelectedRows)) {
            $salesCommissions = SalesCommission::where('created_by', auth()->id())->where('sales_Agent_id', $salesAgent->id)->get();
        } else {
            $salesCommissions = SalesCommission::whereIn('id', explode(',', $request->SelectedRows))->get();
        }

        $selectedColumns = explode(',', $request->selectedColumns);
        $columns = [];
        foreach ($selectedColumns as $column) {
            $columns[] = str_replace(' ', '_', strtolower($column));
        }

        return Helpers::exportFileSettings($request->exportFormat,'sales_commissions',$salesCommissions,$columns);

    }
}
