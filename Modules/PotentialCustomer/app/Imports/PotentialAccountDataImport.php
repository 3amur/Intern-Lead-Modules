<?php

namespace Modules\PotentialCustomer\app\Imports;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Modules\PotentialCustomer\app\Models\LeadAccount;
use Modules\PotentialCustomer\app\Models\LeadAccountImport;



class PotentialAccountDataImport implements ToCollection, WithChunkReading, WithHeadingRow,SkipsEmptyRows
{
    public $match_columns = [];
    public function __construct($match_columns)
    {
        $this->match_columns = $match_columns;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        $validationRules = [
            'account_name' => 'required|string|max:100|min:3',
            'lead_account_title' => 'nullable|string|max:100|min:3',
            'email' => 'nullable|email|unique:lead_account_import,email',
            'website' => 'nullable|url',
            'personal_number' => 'required|min:11|max:15|unique:lead_account_import,personal_number',
            'mobile' => 'nullable|min:11|max:15|unique:lead_account_import,mobile',
            'phone' => 'nullable|min:7|max:15|unique:lead_account_import,phone',
            'zip_code' => 'nullable|string|max:10',
            'address' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:500',
        ];
        $fails_rows_array_with_errors = [];

        foreach ($rows as $number => $row) {
            $array = [];
            foreach ($this->match_columns as $key => $value) {
                $array[$key] = $row[$value];
            }

            $array['personal_number'] = strval($array['personal_number']) ;
            $validator = Validator::make($array, $validationRules,);
            $array['created_by'] = auth()->id() ?? 1;
            $array['created_as'] = 'potential';
            $array['condition'] = 'potential';

            DB::beginTransaction();
            try {
                if (!$validator->fails()) {
                    $accountName = $array['account_name'];

                    $personalNumber = $array['personal_number'];
                    $specialChars = ['+', '(', ')', ' ', '-', '.'];
                    foreach ($specialChars as $char) {
                        if (strpos($personalNumber, $char) !== false) {
                            $array['personal_number'] = str_replace(['+', '(', ')', ' ', '-', '.'], '', $array['personal_number']);
                        }
                        if (!empty($array['mobile'])  && strpos($array['mobile'], $char) !== false) {
                            $array['mobile'] = str_replace(['+', '(', ')', ' ', '-', '.'], '', $array['mobile']);
                        }
                        if (!empty($array['phone'] ) && strpos($array['phone'], $char) !== false) {
                            $array['phone'] = str_replace(['+', '(', ')', ' ', '-', '.'], '', $array['phone']);
                        }
                    }
                    $potentialAccount = LeadAccount::where('account_name', $accountName)->where('created_by',auth()->id())->first();
                    if (!empty($potentialAccount) ) {
                        $array['is_new'] = false;
                        $array['has_changes'] = false;
                        $array['old_account_name'] = null;
                        $array['old_account_contact_name'] = null;
                        $array['old_personal_number'] = null;
                        $array['old_condition'] = null;
                        //==============================
                        if (!empty($array['account_name']) && trim($array['account_name']) != trim($potentialAccount->account_name)) {
                            $array['old_account_name'] =$potentialAccount->account_name;
                            $array['has_changes'] = true;
                        }
                        if (!empty($array['account_contact_name']) && trim($array['account_contact_name']) != trim($potentialAccount->account_contact_name)) {
                            $array['old_account_contact_name'] =$potentialAccount->account_contact_name;
                            $array['has_changes'] = true;
                        }
                        if (!empty($array['personal_number']) && trim($array['personal_number']) != trim($potentialAccount->personal_number)) {
                            $array['old_personal_number'] = $potentialAccount->personal_number;
                            $array['has_changes'] = true;
                        }
                        if (!empty($array['condition']) && trim($array['condition']) != trim($potentialAccount->condition)) {
                            $array['old_condition'] = $potentialAccount->condition;
                            $array['has_changes'] = true;
                        }
                        //dd($array);
                    } else {
                        //dd($array);
                        $array['has_changes'] = false;
                        $array['is_new'] = true;
                    }
                    $founded_potential_accounts = LeadAccountImport::where('account_name', $array['account_name'])->where('created_as','potential')->first();

                    if (empty($founded_potential_accounts) && empty($founded_potential_accounts->id)) {
                        $potentialAccount = LeadAccountImport:: create($array);
                    }
                    } else {
                    if (count($validator->errors()->all()) > 0) {
                        $fails_rows_array_with_errors[$number] = $validator->errors()->all();
                        $invalid_data_array = [];
                        $invalid_data_array['model'] = 'potential_account';
                        $invalid_data_array['row'] = json_encode($row->toArray());
                        $invalid_data_array['errors'] = json_encode($validator->errors()->all());
                        $invalid_data_array['created_by'] = auth()->id() ?? 0;
                        DB::table('import_data_invalid_rows')->insert($invalid_data_array);
                    }
                }

                DB::commit();

            } catch (\Exception $e) {
                DB::rollback();
                Alert::error('Error', 'Error In Import');
                throw $e;
            }
        }
        Session::put('fails_rows_array_with_errors', $fails_rows_array_with_errors);
    }
    public function chunkSize(): int
    {
        return 1000;
    }
}
