<?php

namespace App\Http\Controllers\Dashboard;

use app\Helpers\Helpers;
use App\Exports\RolesExport;
use Illuminate\Http\Request;
use App\DataTables\RolesDataTable;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RolesDataTable $dataTable)
    {
        return $dataTable->render('dashboard.pages.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.pages.roles.create_edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validateRoles($request);
        $role = Role::create([
            'name' => $request->name,
            'description' => $request->description,
            'status'=> $request->status,
            'created_by'=>auth()->id()
        ]);
        $role->givePermissionTo($request->permissions);
        Alert::success(__('Success'),__('Create Successfully'));
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('dashboard.pages.roles.create_edit',compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name'=>'required|unique:roles,name,'.$role->id,
            'description'=>'nullable|string',
            'status'=> 'required|string',
        ]);

        $role->update([
            'name'=> $request->name,
            'description'=>$request->description,
            'permissions'=>$request->permissions,
            'status'=> $request->status,
            'updated_by'=>auth()->id()
        ]);
        $role->syncPermissions($request->permissions);

        Alert::success(__('Success'),__('Update Successfully'));
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->update([
            'deleted_by' => auth()->id()
        ]);
        $role->delete();
        Alert::success(__('Success'),__('Role Deleted Successfully'));
    }

    public function validateRoles($request){
        return $request->validate([
            'name'=>'required|unique:roles,name',
            'description'=>'nullable|string',
            'status'=> 'required|string',
        ]);
    }

    public function export(Request $request)
    {
        if (empty($request->SelectedRows)) {
            $roles = Role::where('created_by', auth()->id())->get();
        } else {
            $roles = Role::whereIn('id', explode(',', $request->SelectedRows))->get();
        }

        $selectedColumns = explode(',', $request->selectedColumns);
        $columns = [];
        foreach ($selectedColumns as $column) {
            $columns[] = str_replace(' ', '_', strtolower($column));
        }

        return Helpers::exportFileSettings($request->exportFormat,'roles',$roles,$columns);

    }
}
