<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTableSetting extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table="data_table_settings";

    public function user()
    {
        return $this->belongsTo(User::class,'created_by');
    }
}
