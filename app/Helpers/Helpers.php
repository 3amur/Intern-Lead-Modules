<?php

namespace app\Helpers;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Modules\PotentialCustomer\app\Exports\DataTableExport;

class Helpers
{
    public static function perUser($permission)
    {
        return (auth()->check()) ? auth()->user()->can($permission) : false;
    }

    public static function log_admin_changes_action($action, $model)
    {
        $changes = $model->getChanges();
        if (!empty($changes)) {
            $skipColumns = ['add_date', 'created_at', 'updated_at', 'added_by', 'created_by', 'updated_by', 'expected_at'];
            $records_change = [];
            $text = '';
            foreach ($changes as $key => $value) {
                if (!in_array($key, $skipColumns)) {
                    $oldVal = $model->getOriginal($key);
                    $newValue = $value;

                    if (in_array($key, ['assign_by', 'assign_to', 'assign_to_approval_type_by', 'assign_to_team_leader_by', 'confirmed_by', 'unconfirmed_by', 'closed_by', 'on_hold_by', 'missing_by', 'open_by', 'approved_by', 'rejected_by', 'replay_by', 'pending_audit_by', 'escalated_by', 'no_approval_needed_by', 'close_rejected_by', 'waiting_client_reply_by', 'mobile_app_request_by', 'duplicated_by', 'closed_cc_by', 'wait_for_internal_ticket_by', 'customer_reply_by', 'not_opened_by', 'lastedit_by', 'add_by', 'follow_up_by', 'follow_up_cancel_by', 'follow_up_id', 'deleted_by'])) {
                        if ($oldVal) {
                            $oldVal = self::getValueFromModelWithKey(\App\Models\User::class, $oldVal, 'name');
                        }
                        if ($newValue) {
                            $newValue = self::getValueFromModelWithKey(\App\Models\User::class, $newValue, 'name');
                        }
                    }
                    $text .= '<li>' . "@lang('main.$key Changed From :oldVal To :newVal', ['oldVal'=>'" . addslashes($oldVal) . "','newVal'=>'" . addslashes($newValue) . "'])</li>";
                    $records_change[] = [
                        $key => [
                            'from' => $model->getOriginal($key),
                            'to' => $value,
                        ]
                    ];
                }
            }
            if ($text) {
                $text = '<ul>' . $text . '<ul>';
            }
            if ($records_change) {
                $createdData = [
                    'action' => (request()->method() == 'DELETE' ? 'delete' : $action),
                    'table_id' => $model->id,
                    'table_name' => $model->getTable(),
                    'text' => $text,
                    'records_change' => json_encode($records_change),
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'request_url' => request()->fullUrl(),
                    'request_method' => request()->method(),
                    'request_data' => json_encode(request()->input()),
                    'created_by' => (auth()->check() ? auth()->id() : 1),
                    'created_at' => date('Y-m-d H:i:s'),
                ];
                \App\Models\Log::create($createdData);
            }
        } else {
            $createdData = [
                'action' => $action,
                'table_id' => $model->id,
                'table_name' => $model->getTable(),
                'text' => ' No Changes Found, its a new data Created in ' . $model->getTable() . ' table .',
                'records_change' => ("New Data Created to '" . $model->getTable() . "' table "),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'request_url' => request()->fullUrl(),
                'request_method' => request()->method(),
                'request_data' => json_encode(request()->input()),
                'created_by' => (auth()->check() ? auth()->id() : 1),
                'created_at' => date('Y-m-d H:i:s'),
            ];
            \App\Models\Log::create($createdData);
        }
    }

    public static function getValueFromModelWithKey($model, $id, $returnCol = 'name')
    {
        $item = $model::find($id);
        if ($item) {
            return $item->$returnCol;
        }
        return $id;
    }


    public static function getFirstLetterOfEachWord($string)
    {
        $words = preg_split("/[\s,_-]+/", $string);
        $acronym = "";
        foreach ($words as $w) {
            $acronym .= mb_substr($w, 0, 1);
        }
        return $acronym;
    }


    public static function return_bytes($val)
    {
        $val = trim($val);

        if (is_numeric($val))
            return $val;

        $last = strtolower($val[strlen($val) - 1]);
        $val = substr($val, 0, -1); // necessary since PHP 7.1; otherwise optional

        switch ($last) {
            // The 'G' modifier is available since PHP 5.1.0
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }
        return $val;
    }


    public static function uploadFile($file,$folderName)
    {
        $path = '/storage/' . $folderName . '/' . date('Y/m/d') . '/';
        if (!file_exists(public_path() . $path)) {
            File::makeDirectory(public_path() . $path, $mode = 0777, true, true);
        }
        $fileName = $folderName . '_' . rand(0000, 9999) . '_' . time();
        $ext = $file->getClientOriginalExtension();
        //file old name
        $oldName = $file->getClientOriginalName();
        $masterName = $fileName . '.' . $ext;
        $file_size = $file->getSize();
        $file_info = $file->getFileInfo();
        $mimeType = $file->getMimeType();
        $file->move(public_path($path), $masterName);
        return [
            'file_dir' => $path,
            'file_name' => $masterName,
            'file_old_name' => $oldName,
            'file_size' => $file_size,
            'file_info' => $file_info,
            'file_ext' => $ext,
            'file_mimeType' => $mimeType,
        ];
    }
    public static function exportFileSettings($fileType,$modelName,$data,$columns)
    {
        if ($fileType == 'excel') {
            $fileName = $modelName . '_' . date('Y-m-d') . '.xlsx';
            return Excel::download(new DataTableExport($data, $columns), $fileName, \Maatwebsite\Excel\Excel::XLSX);
        } elseif ($fileType == 'pdf') {
            $fileName = $modelName . '_' . date('Y-m-d') . '.pdf';
            return Excel::download(new DataTableExport($data, $columns), $fileName, \Maatwebsite\Excel\Excel::DOMPDF);
        } elseif ($fileType == 'csv') {
            $fileName = $modelName . '_' . date('Y-m-d') . '.csv';
            return Excel::download(new DataTableExport($data, $columns), $fileName, \Maatwebsite\Excel\Excel::CSV);
        }
    }
}
