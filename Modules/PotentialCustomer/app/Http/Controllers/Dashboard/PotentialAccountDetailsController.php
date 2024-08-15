<?php

namespace Modules\PotentialCustomer\app\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Nwidart\Modules\Routing\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Modules\PotentialCustomer\app\Models\LeadAccount;
use Modules\PotentialCustomer\app\Models\PotentialAccountDetails;
use Modules\PotentialCustomer\app\Http\Requests\PotentialAccountDetailsRequest;

class PotentialAccountDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort(404);
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
    public function show(PotentialAccountDetails $potentialAccountDetails)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PotentialAccountDetails $potentialAccountDetails, LeadAccount $potentialAccount)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PotentialAccountDetailsRequest $request, LeadAccount $potentialAccount)
    {
        self::updateDetails($request, $potentialAccount->potentialAccountDetails);
        Alert::success(__('Success'), __('Potential Account Details  Edited Successfully'));
        return redirect()->back();
    }

    public static function updateDetails($request, $potentialAccountDetails)
    {

        $potentialAccountDetails->update([
            'starting_date' => $request->starting_date,
            'current_insurer' => $request->current_insurer,
            'utilization' => $request->utilization,
            'potential_premium' => $request->potential_premium,
            'chance_of_sale' => $request->chance_of_sale,
            'price_range_min' => $request->price_range_min,
            'price_range_max' => $request->price_range_max,
            'reason' => $request->reason,
            'updated_by' => auth()->id()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( LeadAccount $potentialAccount)
    {
        $potentialAccountDetails = $potentialAccount->potentialAccountDetails;
        $potentialAccountDetails->update([
            'starting_date' => null,
            'current_insurer' => null,
            'utilization' => null,
            'potential_premium' => null,
            'chance_of_sale' => null,
            'price_range_min' => null,
            'price_range_max' => null,
            'reason' => null,
            'deleted_by' => auth()->id(),
        ]);
        Alert::success(__('Success'), __('Potential Account Details  Deleted Successfully'));
        return redirect()->back();
    }
}
