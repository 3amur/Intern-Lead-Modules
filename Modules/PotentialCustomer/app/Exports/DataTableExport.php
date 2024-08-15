<?php

namespace Modules\PotentialCustomer\app\Exports;

use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;


class DataTableExport implements FromCollection, WithHeadings, WithMapping
{
    protected $model =[];
    protected  $columns = [];
    public function __construct($model,$columns)
    {
        $this->model = $model;
        $this->columns = $columns;
        //dd($this->columns);
    }

    public function collection()
    {
        return collect($this->model);
    }
    public function map($model) : array {

        $rowData = [];

        foreach($this->columns as $column)
        {
            $rowData[] = $model[$column] ?? null;
        }
        return $rowData;
    }
    public function headings(): array
    {
        return $this->columns;
    }
}
