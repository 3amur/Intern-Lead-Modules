<?php
namespace Modules\PotentialCustomer\app\Http\Controllers\Dashboard;

use app\Helpers\Helpers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\HeadingRowImport;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Modules\PotentialCustomer\app\Models\LeadAccount;
use Modules\PotentialCustomer\app\Exports\DataTableExport;
use Modules\PotentialCustomer\app\Exports\InvalidRowExport;
use Modules\PotentialCustomer\app\Models\ImportDataInvalidRow;
use Modules\PotentialCustomer\app\Models\ImportedCustomerData;
use Modules\PotentialCustomer\app\Exports\ImportedCustomerDataExport;
use Modules\PotentialCustomer\app\Imports\ImportedCustomerDataImport;
use Modules\PotentialCustomer\app\Models\ImportedCustomerDataBeforeInsert;
use Modules\PotentialCustomer\app\Exports\CollectedCustomerDataFromImportExport;

class ImportedCustomerDataController
{

    /*  -------------------- Import Functions ------------------------ */
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|mimes:csv,txt,xlsx,xls,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet|max:' . Helpers::return_bytes(ini_get('upload_max_filesize')),
        ]);
        Session::put('inserted', false);
        ImportedCustomerData::where('created_by', auth()->id())->delete();
        ImportDataInvalidRow::where('created_by', auth()->id())->where('model','collected_customer_data')->delete();
        if ($validator->fails()) {
            $messages = '';
            foreach ($validator->errors()->all() as $error) {
                $messages .= $error . ' ';
            }
            return response()->json(['success' => false, 'message' => $messages]);
        } else {
            $file = $request->file('file');
            $fileDataArray = Helpers::uploadFile($file,'collected_customerData');
            $headings = (new HeadingRowImport)->toArray(public_path($fileDataArray['file_dir'] . $fileDataArray['file_name'])); // set csv path here or
            $match_columns = $headings[0][0];
            $potentialAccountId = $request->input('potentialAccountId');

            Session::put('fileColumns', $match_columns);
            Session::put('fileDataArray', json_encode($fileDataArray));
            return response()->json(['success' => true, 'message' => __('Success upload file will redirect ...'), 'redirect_url' => route('imported_customer_data.matchColumns', ['potentialAccountId' => $potentialAccountId])]);
        }
    }

    public function matchColumns($potentialAccountId)
    {
        $potentialAccount = LeadAccount::findOrFail($potentialAccountId);

        if (Session::get('inserted') == true) {
            return back();
        }
        $fileColumns = Session::get('fileColumns');
        if (file_exists(base_path('/Modules/PotentialCustomer/resources/views/pages/leads/collected_data/match_import.blade.php'))) {
            $tableColumns = [
                'Policy Holder' => 'policy_holder',
                'Member Name' => 'member_name',
                'Employee Code' => 'employee_code',
                'Insurance Category' => 'insurance_category',
                'Gender' => 'gender',
                'Medical Code' => 'medical_code',
                'Date of Birth' => 'date_of_birth',
                'Marital Status' => 'marital_status',
                'Start Date' => 'start_date',
                'End Date' => 'end_date',
                'HOF ID' => 'hof_id',
                'Optical' => 'optical',
                'Dental' => 'dental',
                'Maternity' => 'maternity',
                'Medication' => 'medication',
                'Labs and Radiology' => 'labs_and_radiology',
                'Room Type' => 'room_type',
                'Notes' => 'notes',
            ];

            $compact = compact('fileColumns', 'tableColumns', 'potentialAccount');
            Session::put('collected_data_progress', 0);
            return view('potentialcustomer::pages.leads.collected_data.match_import', $compact);
        }
    }


    public function matchColumnUpdate(Request $request)
    {
        try {
            Session::put('inserted', true);
            Session::put('fails_rows_array_with_errors', null);
            $match_columns = [];
            foreach (json_decode($request->columns) as $key => $value) {
                if ($value) {
                    $match_columns[strtolower($key)] = strtolower($value);
                }
            }
            $file = json_decode(Session::get('fileDataArray'));
            $potentialAccountId = $request->potential_account_id;
            Session::put('collected_data_progress', 0);
            Excel::import(new ImportedCustomerDataImport($match_columns, $potentialAccountId), public_path($file->file_dir . $file->file_name));
            return response()->json(['success' => true, 'message' => __('Success upload file will redirect ...'), 'redirect_url' => route('imported_customer_data.getImportedData', ['potential_account_id' => $potentialAccountId])]);
        } catch (\Exception $e) {
            Alert::error('Error ','Error Found' . $e);
        }
    }


    public function getImportedData($potentialAccountId)
    {
        /* $duplicated_emailLists = ImportedCustomerData::where('created_by', auth()->id())
            ->where('is_new', 0)
            ->where('has_changes', 0)
            ->get();

        $changed_emailLists = ImportedCustomerData::where('created_by', auth()->id())
            ->where('is_new', 0)
            ->where('has_changes', 1)
            ->get(); */

        $collectedData = ImportedCustomerDataBeforeInsert::where('created_by', auth()->id())->where('is_new', 1)->get();

        if (!empty(Session::get('fails_rows_array_with_errors'))) {
            $fails_rows_array_with_errors = Session::get('fails_rows_array_with_errors');
        } else {
            $fails_rows_array_with_errors = [];
        }

        return view('potentialcustomer::pages.leads.collected_data.mapping_data', compact('collectedData', 'potentialAccountId', 'fails_rows_array_with_errors'));
    }


    public function insertNewData()
    {
        try {
            $new_collected_data = ImportedCustomerDataBeforeInsert::where('created_by', auth()->id())->where('is_new', 1)->get();
            foreach ($new_collected_data as $row) {
                ImportedCustomerData::create([
                    'policy_holder' => $row->policy_holder,
                    'member_name' => $row->member_name,
                    'employee_code' => $row->employee_code,
                    'insurance_category' => $row->insurance_category,
                    'gender' => $row->gender,
                    'medical_code' => $row->medical_code,
                    'marital_status' => $row->marital_status,
                    'date_of_birth' => $row->date_of_birth,
                    'start_date' => $row->start_date,
                    'end_date' => $row->end_date,
                    'optical' => $row->optical,
                    'dental' => $row->dental,
                    'maternity' => $row->maternity,
                    'medication' => $row->medication,
                    'labs_and_radiology' => $row->labs_and_radiology,
                    'room_type' => $row->room_type,
                    'hof_id' => $row->hof_id,
                    'notes' => $row->notes,
                    'potential_account_id' => $row->potential_account_id,
                    'status' => 'active',
                    'created_by' => auth()->id(),
                ]);
            }

            $potentialAccountId = $row->potential_account_id;
            Alert::success(__('Success'), __('Collected Customer Data inserted Successfully'));
            return redirect()->route('collected_customer_data.showCollectedDataDetails', ['potential_account' => $potentialAccountId]);
        } catch (\Exception $e) {
            return redirect()->route('collected_customer_data.showCollectedDataDetails', ['potential_account' => $potentialAccountId])->with($e);
        }
    }
    /*  -------------------- Export Functions ------------------------ */

    public function exportInvalidRows($potentialAccountId)
    {
        $potentialAccount = LeadAccount::findOrFail($potentialAccountId);
        $fileName = Str::slug($potentialAccount->account_name) . '-invalid-collected-data-rows.xlsx';
        $collectedData = ImportDataInvalidRow::where('created_by', auth()->id())->where('model','collected_customer_data')->get();
        $export = new InvalidRowExport($collectedData);
        return Excel::download($export, $fileName, \Maatwebsite\Excel\Excel::XLSX);
    }

    public function exportNewData($potentialAccountId)
    {
        $potentialAccount = LeadAccount::findOrFail($potentialAccountId);
        $fileName = Str::slug($potentialAccount->account_name) . 'new-imported-data-before-insert.xlsx';
        $new_collected_data = ImportedCustomerDataBeforeInsert::where('created_by', auth()->id())->where('is_new', 1)->get();
        $export = new CollectedCustomerDataFromImportExport($new_collected_data);
        return Excel::download($export, $fileName, \Maatwebsite\Excel\Excel::XLSX);
    }

    public function exportCollectedDataFromImport($potentialAccountId)
    {
        $potentialAccount = LeadAccount::findOrFail($potentialAccountId);
        $fileName = Str::slug($potentialAccount->account_name) . '-imported-data.xlsx';
        $collected_data = ImportedCustomerData::where('created_by', auth()->id())->where('potential_account_id', $potentialAccountId)->get();
        return Excel::download(new CollectedCustomerDataFromImportExport($collected_data), $fileName, \Maatwebsite\Excel\Excel::XLSX);
    }


    public function export(Request $request,$potentialAccountId)
    {
        $potentialAccount = LeadAccount::findOrFail($potentialAccountId);
        if (empty($request->SelectedRows)) {
            $collectedData = ImportedCustomerData::where('potential_account_id',$potentialAccountId)->where('created_by', auth()->id())->get();
        } else {
            $collectedData = ImportedCustomerData::whereIn('id', explode(',', $request->SelectedRows))->get();
        }

        $selectedColumns = explode(',', $request->selectedColumns);
        $columns = [];
        foreach ($selectedColumns as $column) {
            $columns[] = str_replace(' ', '_', strtolower($column));
        }
        return Helpers::exportFileSettings($request->exportFormat,'imported_data_of_'.$potentialAccount->account_name,$collectedData,$columns);
    }

}
