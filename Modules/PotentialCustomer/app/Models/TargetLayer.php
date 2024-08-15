<?php

namespace Modules\PotentialCustomer\app\Models;

use App\Models\User ;
use app\Helpers\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\PotentialCustomer\app\Models\TargetType;
use Modules\PotentialCustomer\app\Models\SalesTarget;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TargetLayer extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];
    protected $table = 'target_layers';

    public function user()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function salesTargets()
    {
        return $this->belongsTo(SalesTarget::class);
    }

    public function targetType()
    {
        return $this->belongsTo(TargetType::class);
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
