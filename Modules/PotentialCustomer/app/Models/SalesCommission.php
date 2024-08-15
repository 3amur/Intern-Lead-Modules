<?php

namespace Modules\PotentialCustomer\app\Models;

use App\Models\User ;
use app\Helpers\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\PotentialCustomer\app\Traits\Helperss;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\PotentialCustomer\app\Models\SalesCommissionLayer;

class SalesCommission extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ["id"];
    protected $table = 'sales_commissions';

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function salesAgent()
    {
        return $this->belongsTo(User::class,'sales_agent_id');
    }

    public function commissionLayers()
    {
        return $this->hasMany(SalesCommissionLayer::class,'sales_commission_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::updated(function ($model) {
            Helpers::log_admin_changes_action('update', $model);
        });
        static::created(function ($model) {
            Helpers::log_admin_changes_action('create', $model);
        });
        static::deleted(function ($model) {
            if (!$model->trashed()) {
                Helpers::log_admin_changes_action('delete', $model);
            }


        });
    }

}

