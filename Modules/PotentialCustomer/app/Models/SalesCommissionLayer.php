<?php

namespace Modules\PotentialCustomer\app\Models;

use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\PotentialCustomer\app\Models\SalesCommission;

class SalesCommissionLayer extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ["id"];
    protected $table = "sales_commission_layers";

    public function salesCommission()
    {
        return $this->belongsTo(SalesCommission::class,'sales_commission_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'created_by');
    }

}
