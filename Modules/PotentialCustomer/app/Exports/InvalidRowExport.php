<?php

namespace Modules\PotentialCustomer\app\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class InvalidRowExport implements FromCollection
{

    public $collected_data = [];
    protected $heading_arr;
    public function __construct($collected_data)
    {
        $heading_arr =  json_decode(  $collected_data->first()->row ,true ) ;
        $heading_arr['errors'] =  $collected_data->first()->errors;
        $this->heading_arr = $heading_arr;
        $this->collected_data = $collected_data;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect($this->collected_data);
    }

    public function map($collected_data) : array {

        $row = json_decode( $collected_data->row ,true )  ;
        $row['errors'] = json_encode( $collected_data->errors ) ;

        return
            $row
        ;
    }
    public function headings() : array {

        return  array_keys($this->heading_arr) ;
    }
}
