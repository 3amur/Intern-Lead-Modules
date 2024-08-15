<?php

namespace Modules\PotentialCustomer\app\Imports;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Modules\PotentialCustomer\app\Models\ImportedCustomerData;
use Modules\PotentialCustomer\app\Models\ImportedCustomerDataBeforeInsert;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;



class ImportedCustomerDataImport implements ToCollection, WithChunkReading, WithHeadingRow,SkipsEmptyRows
{
    public $match_columns = [];
    public $potentialAccountId;
    public function __construct($match_columns, $potentialAccountId)
    {
        $this->match_columns = $match_columns;
        $this->potentialAccountId = $potentialAccountId;
    }



    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        $validationRules = [
            'policy_holder' => 'nullable|string|max:100',
            'member_name' => 'nullable|string|max:100',
            'employee_code' => 'nullable|string|max:100',
            'insurance_category' => 'nullable|string|max:50',
            'gender' => 'nullable|string|max:50',
            'medical_code' => 'nullable|string',
            'marital_status' => 'nullable|string|max:50',
            'date_of_birth' => 'nullable|date|date_format:YYYY-MM-DD,m/d/Y,d F Y,d/m/Y,m-d-Y,Y-m-d,d.m.Y,Y/m/d,d-m-Y,Y.m.d,d M Y,Y F d,Y M d,d/m/y,m-d-y,y-m-d,d.m.y,y/m/d,d-m-y,y.m.d,d-M-y,M-d-y,y-M-d,d/M/y,M/d/y,y/M/d,d/M/Y,M/d/Y,Y/M/d,d M Y,d/m/Y H:i:s',
            'start_date' => 'nullable|date|date_format:YYYY-MM-DD,m/d/Y,d F Y,d/m/Y,m-d-Y,Y-m-d,d.m.Y,Y/m/d,d-m-Y,Y.m.d,d M Y,Y F d,Y M d,d/m/y,m-d-y,y-m-d,d.m.y,y/m/d,d-m-y,y.m.d,d-M-y,M-d-y,y-M-d,d/M/y,M/d/y,y/M/d,d/M/Y,M/d/Y,Y/M/d,d M Y,d/m/Y H:i:s' ,
            'end_date' => 'nullable|date|after:start_date|date_format:YYYY-MM-DD,m/d/Y,d F Y,d/m/Y,m-d-Y,Y-m-d,d.m.Y,Y/m/d,d-m-Y,Y.m.d,d M Y,Y F d,Y M d,d/m/y,m-d-y,y-m-d,d.m.y,y/m/d,d-m-y,y.m.d,d-M-y,M-d-y,y-M-d,d/M/y,M/d/y,y/M/d,d/M/Y,M/d/Y,Y/M/d,d M Y,d/m/Y H:i:s',
            'optical' => 'nullable|string|max:100',
            'dental' => 'nullable|string|max:100',
            'maternity' => 'nullable|string|max:100',
            'medication' => 'nullable|string|max:100',
            'labs_and_radiology' => 'nullable|string|max:100',
            'room_type'=>'nullable|string|max:50',
            'hof_id'=>'nullable|string|max:50',
            'notes' => 'nullable|string|max:500',
        ];
        $fails_rows_array_with_errors = [];

        foreach ($rows as $number => $row) {
            $array = [];
            foreach ($this->match_columns as $key => $value) {
                $array[$key] = $row[$value];
            }
            $validator = Validator::make($array, $validationRules);
            $array['created_by'] = auth()->id() ?? 1;
            $array['potential_account_id'] = $this->potentialAccountId;
            $array['is_new'] = true;

            DB::beginTransaction();
            try {
                if (!$validator->fails()) {
                    try {
                        if (!empty($array['start_date'])) {
                            $array['start_date'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($array['start_date'])->format('Y-m-d');
                        }

                        if (!empty($array['end_date'])) {
                            $array['end_date'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($array['end_date'])->format('Y-m-d');
                        }
                        if (!empty($array['date_of_birth'])) {
                            $array['date_of_birth'] = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($array['date_of_birth'])->format('Y-m-d');
                        }

                        if (array_key_exists('insurance_category', $array)) {
                            $array['insurance_category'] = strtolower($array['insurance_category']);
                        } else {
                            $array['insurance_category'] = null;
                        }

                        if (array_key_exists('gender', $array)) {
                            $array['gender'] = strtolower($array['gender']);
                        } else {
                            $array['gender'] = null;
                        }

                        if (array_key_exists('marital_status', $array)) {
                            $array['marital_status'] = strtolower($array['marital_status']);
                        } else {
                            $array['marital_status'] = null;
                        }
                        if (array_key_exists('employee_code', $array) || is_int($array['employee_code']) ) {
                            $array['employee_code'] = strval($array['employee_code']);
                        }

                        if (array_key_exists('employee_code', $array) )  {
                            $array['employee_code'] = strval($array['employee_code']);
                        }
                        if (array_key_exists('medical_code', $array) )  {
                            $array['medical_code'] = strval($array['medical_code']);
                        }

                        if (array_key_exists('room_type', $array)) {
                            $array['room_type'] = strtolower($array['room_type']);
                        } else {
                            $array['room_type'] = null;
                        }

                        if (array_key_exists('hof_id', $array)) {
                            $array['hof_id'] = strtolower($array['hof_id']);
                        } else {
                            $array['hof_id'] = null;
                        }

                    } catch (\Exception $e) {
                        DB::rollback();
                        Alert::error('Error', 'Error In Import');
                        throw $e;
                    }


                    ImportedCustomerDataBeforeInsert:: create($array);

                    } else {
                    if (count($validator->errors()->all()) > 0) {
                        $fails_rows_array_with_errors[$number] = $validator->errors()->all();
                        $invalid_data_array = [];
                        $invalid_data_array['model'] = 'collected_customer_data';
                        $invalid_data_array['row'] = json_encode($row->toArray());
                        $invalid_data_array['errors'] = json_encode($validator->errors()->all());
                        $invalid_data_array['created_by'] = auth()->id() ?? 0;
                        DB::table('import_data_invalid_rows')->insert($invalid_data_array);
                    }
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                Alert::error('Error ','Error Found in Import Process');
            }
        }
        Session::put('fails_rows_array_with_errors', $fails_rows_array_with_errors);
    }


    public function chunkSize(): int
    {
        return 1000;
    }
}
