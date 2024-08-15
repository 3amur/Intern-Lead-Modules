<?php

namespace Modules\PotentialCustomer\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportDataInvalidRow extends Model
{
    use HasFactory;

    protected $guarded=['id'];
    protected $table = 'import_data_invalid_rows';
}
