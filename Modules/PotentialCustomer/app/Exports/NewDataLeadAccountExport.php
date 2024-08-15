<?php

namespace Modules\PotentialCustomer\app\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;


class NewDataLeadAccountExport implements FromCollection, WithHeadings, WithMapping
{
    protected $leadAccounts = [];

    public function __construct($leadAccounts)
    {
        $this->leadAccounts = $leadAccounts;

    }

    public function collection()
    {
        return collect($this->leadAccounts);
    }
    public function map($leadAccounts) : array {
        return [
            $leadAccounts->account_name,
            $leadAccounts->lead_account_title,
            $leadAccounts->personal_number,
            $leadAccounts->phone,
            $leadAccounts->mobile,
            $leadAccounts->email,
            $leadAccounts->website,
            $leadAccounts->address,
            $leadAccounts->notes,
            $leadAccounts->zip_code,
            $leadAccounts->image,
            $leadAccounts->status,
            $leadAccounts->condition,
            $leadAccounts->created_as,
            $leadAccounts->city ? $leadAccounts->city->state->country->name:'N/A',
            $leadAccounts->city ? $leadAccounts->city->state->name:'N/A',
            $leadAccounts->city ? $leadAccounts->city->name:'N/A',
            $leadAccounts->leadSource ? $leadAccounts->leadSource->title : 'N/A',
            $leadAccounts->leadStatus ? $leadAccounts->leadStatus->title : 'N/A',
            $leadAccounts->leadValue ? $leadAccounts->leadValue->title : 'N/A',
            $leadAccounts->salesAgent ? $leadAccounts->salesAgent->name : 'N/A',
            $leadAccounts->created_at,
            $leadAccounts->updated_at,
        ] ;
    }
    public function headings(): array
    {
        return [
            'Account Name',
            'Lead Account Title',
            'Personal Number',
            'Phone',
            'Mobile',
            'Email',
            'Website',
            'Address',
            'Notes',
            'Zip Code',
            'Image',
            'Status',
            'Condition',
            'Created As',
            'Country ',
            'State ',
            'City ',
            'Lead Source ',
            'Lead Status ',
            'Lead Value ',
            'Sales Agent',
            'Created At',
            'Updated At',
        ];
    }
}
