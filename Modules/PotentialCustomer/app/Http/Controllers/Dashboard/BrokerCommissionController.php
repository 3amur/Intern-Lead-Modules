<?php

namespace Modules\PotentialCustomer\app\Http\Controllers\Dashboard;

use app\Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Nwidart\Modules\Routing\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Modules\PotentialCustomer\app\Models\Broker;
use Modules\PotentialCustomer\app\Models\BrokerCommission;
use Modules\PotentialCustomer\app\Models\BrokerCommissionLayer;
use Modules\PotentialCustomer\app\DataTables\BrokerCommissionsDataTable;
use Modules\PotentialCustomer\app\Http\Requests\BrokerCommissionRequest;

class BrokerCommissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BrokerCommissionsDataTable $dataTable, Broker $broker)
    {
        return $dataTable->render('potentialcustomer::pages.sales-target.broker_commission.index',compact('broker'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Broker $broker)
    {
        return view('potentialcustomer::pages.sales-target.broker_commission.create_edit',compact('broker'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrokerCommissionRequest $request, Broker $broker)
    {
        try {
            $amountFrom = $this->sanitizeInput($request->input('amount_from'));
            $amountTo = $this->sanitizeInput($request->input('amount_to'));
            $percent = $this->sanitizeInput($request->input('percent'));

            $validated = $this->validateInput($amountFrom, $amountTo, $percent);

            if (!$validated) {
                Alert::error(__('error'), __("All values must be integers."));
                return redirect()->route('broker_commissions.index',['broker'=>$broker->id]);
            }

            DB::beginTransaction();

            $brokerCommission = BrokerCommission::create([
                'title' => $request->title,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'notes' => $request->notes,
                'status' => $request->status,
                'broker_id' => $broker->id,
                'created_by' => auth()->id(),
            ]);

            $brokerCommissionLayers = [
                'from' => $amountFrom,
                'to' => $amountTo,
                'percentage' => $percent,
            ];

            foreach ($brokerCommissionLayers['from'] as $key => $value) {
                BrokerCommissionLayer::create([
                    'from' => $brokerCommissionLayers['from'][$key],
                    'to' => $brokerCommissionLayers['to'][$key],
                    'percentage' => $brokerCommissionLayers['percentage'][$key],
                    'broker_commission_id' => $brokerCommission->id,
                    'created_by' => auth()->id(),
                ]);
            }

            DB::commit();
            Alert::success(__('success'), __('Commission Created Successfully'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error(__('error'),  __('An error occurred while processing your request.'));
            return redirect()->route('broker_commissions.index',['broker'=>$broker->id]);
        }
    }

    private function sanitizeInput($input)
    {
        return array_map(function ($value) {
            return intval(str_replace(',', '', $value));
        }, $input);
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
    public function show(BrokerCommission $brokerCommission,Broker $broker)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BrokerCommission $brokerCommission,Broker $broker)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BrokerCommission $brokerCommission,Broker $broker)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BrokerCommission $brokerCommission,Broker $broker)
    {
        abort(404);
    }

    public function export(Request $request,Broker $broker)
    {
        if (empty($request->SelectedRows)) {
            $brokerCommissions = BrokerCommission::where('created_by', auth()->id())->where('broker_id', $broker->id)->get();
        } else {
            $brokerCommissions = BrokerCommission::whereIn('id', explode(',', $request->SelectedRows))->get();
        }

        $selectedColumns = explode(',', $request->selectedColumns);
        $columns = [];
        foreach ($selectedColumns as $column) {
            $columns[] = str_replace(' ', '_', strtolower($column));
        }

        return Helpers::exportFileSettings($request->exportFormat,'broker_commissions',$brokerCommissions,$columns);

    }
}
