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
use Modules\PotentialCustomer\app\Exports\StatesExport;
use Modules\PotentialCustomer\app\DataTables\StateDataTable;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(StateDataTable $dataTable)
    {
        return $dataTable->render('potentialcustomer::pages.countries-states-cities.states.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::select('id', 'name')->get();
        return view('potentialcustomer::pages.countries-states-cities.states.create_edit',compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=> 'required|string|max:100|unique:states,name',
            'status'=> 'required|string',
            'country_id'=> 'required|integer',

        ]);

        State::create([
            'name'=> $request->name,
            'status'=> $request->status,
            'country_id'=> $request->country_id,
            'created_by'=> auth()->id()
        ]);

        Alert::success(__('Success'),__('State Created Successfully'));
        return redirect()->route('states.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(State $state)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(State $state)
    {
        $countries = Country::select('id', 'name')->get();
        $country =  Country::findOrFail($state->country_id);
        return view('potentialcustomer::pages.countries-states-cities.states.create_edit',compact('state', 'country', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, State $state)
    {
        $request->validate([
            'name'=> 'required|string|max:100|unique:states,name,'.$state->id,
            'status'=> 'required|string',
            'country_id'=> 'required|integer',

        ]);
        $state->update([
            'name'=> $request->name,
            'status'=> $request->status,
            'country_id'=> $request->country_id,
            'updated_by'=> auth()->id()
        ]);
        if($request->status == 'active')
        {
            if($state->country->status == 'active')
            {
                $state->cities()->update(['status'=>$request->status]);
            }else{
                $state->country()->update(['status'=>$request->status]);
                $state->cities()->update(['status'=>$request->status]);
            }

        }else{
            $state->cities()->update(['status'=>$request->status]);
        }

        Alert::success(__('Success'),__('State Edited Successfully'));
        return redirect()->route('states.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(State $state)
    {
        $state->update([
            'deleted_by' => auth()->id(),
        ]);
        City::where('state_id', $state->id)->delete();
        $state->delete();
        Alert::success(__('Success'),__('State Deleted Successfully'));
    }

    public function getStates(Request $request)
    {
        if($request->ajax()){
            if($request->country_id){
                $html='<option value="">'.__('Select :type',['type'=>__('State')]).'</option>';
                $states=State::where('country_id',request('country_id'))->where('status', 'active')->pluck('name','id')->toArray();
                foreach ($states as $id=>$name){
                    $html.='<option '.($request->selected==$id?'selected="selected"':'').' value="'.$id.'">'.$name.'</option>';
                }
                return response()->json(['success' => true, 'data' => $html]);
            }
        }
        return abort(404);
    }

    public function export(Request $request)
    {
        if (empty($request->SelectedRows)) {
            $states = State::where('created_by', auth()->id())->get();
        } else {
            $states = State::whereIn('id', explode(',', $request->SelectedRows))->get();
        }

        $selectedColumns = explode(',', $request->selectedColumns);
        $columns = [];
        foreach ($selectedColumns as $column) {
            $columns[] = str_replace(' ', '_', strtolower($column));
        }

        return Helpers::exportFileSettings($request->exportFormat,'states',$states,$columns);

    }
}
