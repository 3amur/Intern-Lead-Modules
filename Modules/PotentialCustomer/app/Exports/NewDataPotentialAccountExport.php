<?php

namespace Modules\PotentialCustomer\app\Exports;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;


class NewDataPotentialAccountExport implements FromCollection, WithHeadings, WithMapping
{
    protected $potentialAccounts = [];

    public function __construct($potentialAccounts)
    {
        $this->potentialAccounts = $potentialAccounts;

    }

    public function collection()
    {
        return collect($this->potentialAccounts);
    }
    public function map($potentialAccounts) : array {
        return [
            $potentialAccounts->account_name,
            $potentialAccounts->lead_account_title,
            $potentialAccounts->personal_number,
            $potentialAccounts->phone,
            $potentialAccounts->mobile,
            $potentialAccounts->email,
            $potentialAccounts->website,
            $potentialAccounts->address,
            $potentialAccounts->notes,
            $potentialAccounts->zip_code,
            $potentialAccounts->image,
            $potentialAccounts->status,
            $potentialAccounts->condition,
            $potentialAccounts->created_as,
            $potentialAccounts->city ? $potentialAccounts->city->state->country->name:'N/A',
            $potentialAccounts->city ? $potentialAccounts->city->state->name:'N/A',
            $potentialAccounts->city ? $potentialAccounts->city->name:'N/A',
            $potentialAccounts->leadSource ? $potentialAccounts->leadSource->title : 'N/A',
            $potentialAccounts->leadStatus ? $potentialAccounts->leadStatus->title : 'N/A',
            $potentialAccounts->leadValue ? $potentialAccounts->leadValue->title : 'N/A',
            $potentialAccounts->salesAgent ? $potentialAccounts->salesAgent->name : 'N/A',
            $potentialAccounts->created_at,
            $potentialAccounts->updated_at,
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
