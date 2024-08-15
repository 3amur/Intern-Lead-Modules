<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\User ;
use app\Helpers\Helpers;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use App\Models\DataTableSetting;
use App\DataTables\UsersDataTable;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UserUpdateRequest;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UsersDataTable $dataTable)
    {
        $tableSetting = DataTableSetting::where('created_by', auth()->id())->where('table_name', 'users')->first();
            return $dataTable->render('dashboard.pages.users.index', compact('dataTable','tableSetting'));

    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::select('id', 'name')->where('status', 'active')->get();
        return view('dashboard.pages.users.create_edit', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $image = NULL;
        if ($request->hasFile('image')) {
            $image = Storage::putFile("users/images", $request->image);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'image' => $image,
            'status' => $request->status,
            'created_by' => auth()->id(),
        ]);

            $user->assignRole(Role::whereIn('id', $request->role_id)->get());
            $user->syncPermissions($request->permissions);
        Alert::success(__('Success'), __('Create Successfully'));
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort(404);
    }

    public function edit(string $id)
    {
        $user = User::where('id', $id)->first();
        return view('dashboard.pages.users.create_edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, string $id)
    {
        $image = NULL;
        $user = User::where('id', $id)->first();
        if ($request->hasFile('image')) {
            Storage::delete($user->image);
            $image = Storage::putFile("users/images", $request->image);
        }
        User::where("id", $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? $request->password : $user->password,
            'image' => $image,
            'status' => $request->status,
            'updated_by' => auth()->id(),
        ]);

        DB::table('model_has_roles')->where('model_id', $id)->delete();
        DB::table('model_has_permissions')->where('model_id', $id)->delete();
        $user->assignRole(Role::whereIn('id', $request->role_id)->get());
        $user->syncPermissions($request->permissions);
        Alert::success(__('Success'), __('Edit Successfully'));
        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::where('id', $id)->first();
        $user->update([
            'deleted_by' => auth()->id()
        ]);
        if ($user->image) {
            Storage::delete($user->image);
        }
        $user->delete();
        Alert::success(__('Success'), __('User Deleted Successfully'));
    }

    public function rolesPermissions(Request $request)
    {
        $data = DB::table('role_has_permissions')
            ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
            ->join('roles', 'role_has_permissions.role_id', '=', 'roles.id')
            ->select('permissions.id', 'permissions.name', 'permissions.group', 'roles.id as role_id', 'roles.name as role_name')
            ->whereIN('role_id', json_decode($request['array']))
            ->get();
        return response()->json([
            'data' => $data
        ]);
    }

    function getRole(Request $request )
    {
        if(!empty($request->role_id)){
            $roles = Role::whereIn('id',$request->role_id)->pluck('name');
            return response()->json([
                'data'=> $roles
                ],200);
        }
        return response()->json(['data'=>[]],200);

    }

    public function export(Request $request)
    {
        if (empty($request->SelectedRows)) {
            $users = User::where('created_by', auth()->id())->get();
        } else {
            $users = User::whereIn('id', explode(',', $request->SelectedRows))->get();
        }

        $selectedColumns = explode(',', $request->selectedColumns);
        $columns = [];
        foreach ($selectedColumns as $column) {
            $columns[] = str_replace(' ', '_', strtolower($column));
        }

        return Helpers::exportFileSettings($request->exportFormat,'users',$users,$columns);

    }

}
