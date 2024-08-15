<?php

namespace App\Exports;

use App\Models\Role;
use Maatwebsite\Excel\Concerns\FromCollection;

class RolesExport implements FromCollection
{
    protected $roles =[];
    protected  $columns = [];
    public function __construct($roles,$columns)
    {
        $this->roles = $roles;
        $this->columns = $columns;
        //dd($this->columns);
    }

    public function collection()
    {
        return collect($this->roles);
    }
    public function map($roles) : array {

        $rowData = [];

        foreach($this->columns as $column)
        {
            $rowData[] = $roles[$column] ?? null;
        }
        return $rowData;
    }
    public function headings(): array
    {
        return $this->columns;
    }
}
