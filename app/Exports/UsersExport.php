<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    protected $users =[];
    protected  $columns = [];
    public function __construct($users,$columns)
    {
        $this->users = $users;
        $this->columns = $columns;
        //dd($this->columns);
    }

    public function collection()
    {
        return collect($this->users);
    }
    public function map($users) : array {

        $rowData = [];

        foreach($this->columns as $column)
        {
            $rowData[] = $users[$column] ?? null;
        }
        return $rowData;
    }
    public function headings(): array
    {
        return $this->columns;
    }
}
