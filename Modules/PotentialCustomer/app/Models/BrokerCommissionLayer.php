<?php

namespace Modules\PotentialCustomer\app\Models;

use app\Helpers\Helpers;
use Illuminate\Foundation\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\PotentialCustomer\app\Models\BrokerCommission;

class BrokerCommissionLayer extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ["id"];
    protected $table = "broker_commission_layers";

    public function brokerCommission()
    {
        return $this->belongsTo(BrokerCommission::class,'broker_commission_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'created_by');
    }


    protected static function boot()
    {
        parent::boot();
        static::updated(function ($model) {
            Helpers::log_admin_changes_action('update',$model);
        });
        static::created(function ($model) {
            Helpers::log_admin_changes_action('create',$model);
        });
        static::deleted(function ($model) {
            if (!$model->trashed()) {
            Helpers::log_admin_changes_action('delete',$model);
            }
        });
    }
}
