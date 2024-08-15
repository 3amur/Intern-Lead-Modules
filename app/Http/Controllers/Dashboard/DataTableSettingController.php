<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Models\DataTableSetting;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class DataTableSettingController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $keyName = explode('/',$request->keyName);
        $tableName = end($keyName);

        if($request->keyValue)
        {
            $oldSettings = DataTableSetting::where('table_name',$tableName)->where('created_by',auth()->id());
            if($oldSettings)
            {
                $oldSettings->delete();
            }
            $newSetting = DataTableSetting::create([
                'table_name'=>$tableName,
                'table_settings'=>$request->keyValue,
                'key_name'=>$request->keyName,
                'created_by'=>auth()->id()
            ]);
            return [
                'data'=>$newSetting
            ];
        }else{
            Alert::error(__('Error'),__('Error In saving , please reload page and try again'));

        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataTableSetting $dataTableSetting)
    {
        abort(404);
    }
}
