<?php
namespace Modules\PotentialCustomer\app\Http\Controllers\Dashboard;

use app\Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Nwidart\Modules\Routing\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Modules\PotentialCustomer\app\Models\TargetType;
use Modules\PotentialCustomer\app\DataTables\TargetTypeDataTable;
use Modules\PotentialCustomer\app\Http\Requests\TargetTypeRequest;

class TargetTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TargetTypeDataTable $dataTable)
    {
        return $dataTable->render('potentialcustomer::pages.sales-target.target_type.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('potentialcustomer::pages.sales-target.target_type.create_edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TargetTypeRequest $request)
    {
        $image = NULL;

        if ($request->has('image')) {
            $image = Storage::put('target-types/images', $request->image);
        }
        TargetType::create([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'image' => $image,
            'created_by' => auth()->id(),
        ]);

        Alert::success(__('Success'), __('Target Type Created Successfully'));
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(TargetType $targetType)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TargetType $targetType)
    {
        return view('potentialcustomer::pages.sales-target.target_type.create_edit', compact('targetType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TargetTypeRequest $request, TargetType $targetType)
    {
        $image = NULL;

        if ($request->has('image')) {
            if ($targetType->image) {
                Storage::delete($targetType->image);
            }
            $image = Storage::put('target-types/images', $request->image);
        }

        $targetType->update([
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'image' => $image,
            'updated_by' => auth()->id(),
        ]);
        Alert::success(__('Success'), __('Target Type Edited Successfully'));
        return redirect()->route('target_types.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TargetType $targetType)
    {
        $targetType->update([
            'deleted_by' => auth()->id()
        ]);
        if ($targetType->image) {
            Storage::delete($targetType->image);
        }
        $targetType->delete();
        Alert::success(__('Success'), __('Target Type Deleted Successfully'));
    }

    public function export(Request $request)
    {
        if (empty($request->SelectedRows)) {
            $targetTypes = TargetType::where('created_by', auth()->id())->get();
        } else {
            $targetTypes = TargetType::whereIn('id', explode(',', $request->SelectedRows))->get();
        }

        $selectedColumns = explode(',', $request->selectedColumns);
        $columns = [];
        foreach ($selectedColumns as $column) {
            $columns[] = str_replace(' ', '_', strtolower($column));
        }

        return Helpers::exportFileSettings($request->exportFormat,'target_types',$targetTypes,$columns);

    }
}
