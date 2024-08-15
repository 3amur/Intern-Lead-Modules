<?php

namespace Modules\PotentialCustomer\app\Http\Controllers\Dashboard;


use app\Helpers\Helpers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Nwidart\Modules\Routing\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Modules\PotentialCustomer\app\Models\Country;
use Modules\PotentialCustomer\app\DataTables\CountryDataTable;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CountryDataTable $dataTable)
    {
        return $dataTable->render('potentialcustomer::pages.countries-states-cities.countries.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('potentialcustomer::pages.countries-states-cities.countries.create_edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required|string|max:100|unique:countries,name',
            'status'=> 'required|string'
        ]);

        Country::create([
            'name'=> $request->name,
            'status'=> $request->status,
            'created_by'=> auth()->id()
        ]);

        Alert::success(__('Success'),__('Country Created Successfully'));
        return redirect()->route('countries.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $country)
    {
        return view('potentialcustomer::pages.countries-states-cities.countries.create_edit',compact('country'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Country $country)
    {
        $request->validate([
            'name'=> 'required|string|max:100|unique:countries,name,'.$country->id,
            'status'=> 'required|string'
        ]);
        $country->update([
            'name'=> $request->name,
            'status'=> $request->status,
            'updated_by'=> auth()->id()
        ]);
        if($request->status)
        {
            $country->states()->update(['status'=>$request->status]);
            foreach($country->states as $state)
            {
                $state->cities()->update(['status'=>$request->status]);
            }

        }
        Alert::success(__('Success'),__('Country Edited Successfully'));
        return redirect()->route('countries.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country)
    {
        $country->update([
            'deleted_by' => auth()->id(),
        ]);
        $country->delete();
        Alert::success(__('Success'),__('Country Deleted Successfully'));
    }

    public function dataTable(CountryDataTable $dataTable)
    {

        return $dataTable->ajax();
    }


    public function export(Request $request)
    {
        if (empty($request->SelectedRows)) {
            $countries = Country::where('created_by', auth()->id())->get();
        } else {
            $countries = Country::whereIn('id', explode(',', $request->SelectedRows))->get();
        }

        $selectedColumns = explode(',', $request->selectedColumns);
        $columns = [];
        foreach ($selectedColumns as $column) {
            $columns[] = str_replace(' ', '_', strtolower($column));
        }
        return Helpers::exportFileSettings($request->exportFormat,'countries',$countries,$columns);

    }
}
