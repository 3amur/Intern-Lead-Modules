<?php

namespace Modules\PotentialCustomer\app\Models;

use App\Models\User ;
use app\Helpers\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\PotentialCustomer\app\Models\Broker;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BrokerType extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id'];
    protected $table = 'broker_types';


    public function brokers()
    {
        return $this->hasMany(Broker::class,'broker_type_id');
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
