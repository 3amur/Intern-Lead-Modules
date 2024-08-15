<?php

namespace Modules\PotentialCustomer\app\Models;

use App\Models\User ;
use app\Helpers\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TargetType extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];
    protected $table = 'target_types';

    public function user()
    {
        return $this->belongsTo(User::class,'created_by');
    }
    public function targetLayers()
    {
        return $this->hasMany(TargetLayer::class,'target_type_id','id');
    }
    public function salesTargets()
    {
        return $this->belongsToMany(SalesTarget::class,'sales_targets_sales_agents','target_type_id','sales_target_id')->withTimestamps();
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
