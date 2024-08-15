<?php

namespace Modules\PotentialCustomer\app\Models;

use app\Helpers\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\PotentialCustomer\app\Models\LeadAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PotentialAccountDetails extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];

    protected $table ="potential_account_details";

    public function potentialAccount()
    {
        return $this->belongsTo(LeadAccount::class,'potential_account_id');
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
