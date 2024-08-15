<?php

namespace Modules\PotentialCustomer\app\Http\Controllers\Dashboard;


use app\Helpers\Helpers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Nwidart\Modules\Routing\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Modules\PotentialCustomer\app\Models\City;
use Modules\PotentialCustomer\app\Models\State;
use Modules\PotentialCustomer\app\Models\Country;
use Modules\PotentialCustomer\app\Exports\CitiesExport;
use Modules\PotentialCustomer\app\Exports\DataTableExport;
use Modules\PotentialCustomer\app\DataTables\CityDataTable;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CityDataTable $dataTable)
    {
        return $dataTable->render('potentialcustomer::pages.countries-states-cities.cities.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::select('id', 'name')->get();
        return view('potentialcustomer::pages.countries-states-cities.cities.create_edit',compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required|string|max:100|unique:cities,name',
            'status'=> 'required|string',
            'country_id'=> 'required|integer',
            'state_id' => 'required|integer'
        ]);

        City::create([
            'name'=> $request->name,
            'status'=> $request->status,
            'country_id'=> $request->country_id,
            'state_id'=> $request->state_id,
            'created_by'=> auth()->id()
        ]);

        Alert::success(__('Success'),__('City Created Successfully'));
        return redirect()->route('cities.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(city $city)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(city $city)
    {
        $countries = Country::select('id', 'name')->get();
        $state = $city->state;
        return view('potentialcustomer::pages.countries-states-cities.cities.create_edit',compact('countries','city','state'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, city $city)
    {
        $request->validate([
            'name'=> 'required|string|max:100|unique:cities,name,'.$city->id,
            'status'=> 'required|string',
            'country_id'=> 'required|integer',
            'state_id' => 'required|integer'
        ]);

        $city->update([
            'name'=> $request->name,
            'status'=> $request->status,
            'country_id'=> $request->country_id,
            'updated_by'=> auth()->id()
        ]);
        Alert::success(__('Success'),__('City Edited Successfully'));
        return redirect()->route('cities.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(city $city)
    {
        $city->update([
            'deleted_by' => auth()->id(),
        ]);
        $city->delete();
        Alert::success(__('Success'),__('City Deleted Successfully'));
    }

    public function getCities(Request $request)
    {
        if($request->ajax()){
            if($request->state_id){
                $html='<option value="">'.__('Select :type',['type'=>__('City')]).'</option>';
                $cities=City::where('state_id',request('state_id'))->where('status', 'active')->pluck('name','id')->toArray();
                foreach ($cities as $id=>$name){

                    $html.='<option '.($request->selected==$id?'selected="selected"':'').' value="'.$id.'">'.$name.'</option>';
                }
                return response()->json(['success'=>true,'data'=>$html]);
            }
        }
        return abort(404);
    }


    public function export(Request $request)
    {
        if (empty($request->SelectedRows)) {
            $cities = City::where('created_by', auth()->id())->get();
        } else {
            $cities = City::whereIn('id', explode(',', $request->SelectedRows))->get();
        }

        $selectedColumns = explode(',', $request->selectedColumns);
        $columns = [];
        foreach ($selectedColumns as $column) {
            $columns[] = str_replace(' ', '_', strtolower($column));
        }

        return Helpers::exportFileSettings($request->exportFormat,'cities',$cities,$columns);

    }
}
