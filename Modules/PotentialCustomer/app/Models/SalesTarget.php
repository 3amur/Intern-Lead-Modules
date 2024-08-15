<?php

namespace Modules\PotentialCustomer\app\Models;

use App\Models\User ;
use app\Helpers\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesTarget extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];
    protected $table = 'sales_targets';

    public function user()
    {
        return $this->belongsTo(User::class,'created_by');
    }
    public function targetTypes()
    {
        return $this->belongsToMany(TargetType::class,'sales_targets_target_types','sales_target_id','target_type_id')->withTimestamps();
    }

    public function salesAgents()
    {
        return $this->belongsToMany(User::class,'sales_targets_sales_agents','sales_target_id','sales_agent_id')->withTimestamps();
    }

    public function hasTargetType(TargetType $targetType)
    {
        return $this->targetTypes->contains($targetType);
    }

    public function targetLayers()
    {
        return $this->hasMany(TargetLayer::class,'sales_target_id','id');
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
