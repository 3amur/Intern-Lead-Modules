<?php

namespace Modules\PotentialCustomer\app\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Nwidart\Modules\Routing\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Modules\PotentialCustomer\app\Models\Team;
use Modules\PotentialCustomer\app\Models\Department;
use Modules\PotentialCustomer\app\DataTables\TeamsDataTable;
use Modules\PotentialCustomer\app\Http\Requests\TeamRequest;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TeamsDataTable $dataTable)
    {
        return $dataTable->render('potentialcustomer::pages.team.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::select('id','title')->where('status','active')->where('created_by',auth()->id())->get();
        return view('potentialcustomer::pages.team.create_edit',compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TeamRequest $request)
    {
        Team::create([
            'title' => $request->title,
            'description' => $request->description,
            'department_id'=> $request->department_id,
            'status' => $request->status,
            'created_by' => auth()->id(),
        ]);

        Alert::success(__('Success'), __('Team Created Successfully'));
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        $departments = Department::select('id','title')->where('status','active')->where('created_by',auth()->id())->get();
        return view('potentialcustomer::pages.team.create_edit',compact('departments','team'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TeamRequest $request, Team $team)
    {
        $team->update([
            'title' => $request->title,
            'description' => $request->description,
            'department_id'=> $request->department_id,
            'status' => $request->status,
            'updated_by' => auth()->id(),
        ]);
        Alert::success(__('Success'), __('Team Edited Successfully'));
        return redirect()->route('teams.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {

        $team->update([
            'deleted_by' => auth()->id(),
        ]);
        $team->delete();
        Alert::success(__('Success'),__('Team Deleted Successfully'));
    }
}
