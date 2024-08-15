<?php

namespace Modules\PotentialCustomer\app\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use Modules\PotentialCustomer\app\Http\Requests\DepartmentRequest;
use Nwidart\Modules\Routing\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Modules\PotentialCustomer\app\Models\Department;
use Modules\PotentialCustomer\app\DataTables\DepartmentsDataTable;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DepartmentsDataTable $dataTable)
    {
        return $dataTable->render('potentialcustomer::pages.departments.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('potentialcustomer::pages.departments.create_edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DepartmentRequest $request)
    {
        Department::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'created_by' => auth()->id(),
        ]);

        Alert::success(__('Success'), __('Department Created Successfully'));
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Department $department)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        return view('potentialcustomer::pages.departments.create_edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DepartmentRequest $request, Department $department)
    {
        $department->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'updated_by' => auth()->id(),
        ]);
        Alert::success(__('Success'), __('Department Edited Successfully'));
        return redirect()->route('departments.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {

        $department->update([
            'deleted_by' => auth()->id(),
        ]);
        $department->delete();
        Alert::success(__('Success'),__('Department Deleted Successfully'));
    }
}
