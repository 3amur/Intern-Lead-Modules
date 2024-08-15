<?php

namespace Modules\PotentialCustomer\app\Exports;

use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;


class CollectedCustomerDataFromImportExport implements FromCollection,WithMapping,WithHeadings
{
    protected $new_collected_data = [];
    protected $heading_arr;

    public function __construct($new_collected_data)
    {
        $this->new_collected_data = $new_collected_data;
        $this->heading_arr = $new_collected_data->first();
    }

    public function collection()
    {
        return collect($this->new_collected_data);
    }
    public function map($new_collected_data) : array {
        return [
            $new_collected_data->policy_holder,
            $new_collected_data->member_name,
            $new_collected_data->employee_code,
            $new_collected_data->medical_code,
            $new_collected_data->gender,
            $new_collected_data->date_of_birth,
            $new_collected_data->marital_status,
            $new_collected_data->start_date,
            $new_collected_data->end_date,
            $new_collected_data->insurance_category,
            $new_collected_data->room_type,
            $new_collected_data->optical,
            $new_collected_data->dental,
            $new_collected_data->medication,
            $new_collected_data->maternity,
            $new_collected_data->hof_id,
            $new_collected_data->labs_and_radiology,
            $new_collected_data->potentialAccount->account_name,
            $new_collected_data->notes,
        ] ;
    }
    public function headings(): array
    {
        return [
            'policy_holder',
            'member_name',
            'employee_code',
            'medical_code',
            'gender',
            'date_of_birth',
            'marital_status',
            'start_date',
            'end_date',
            'insurance_category',
            'room_type',
            'optical',
            'dental',
            'medication',
            'maternity',
            'hof_id',
            'labs_and_radiology',
            'potential_account',
            'notes',
        ];
    }
}
