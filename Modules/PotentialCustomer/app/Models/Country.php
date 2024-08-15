<?php

namespace Modules\PotentialCustomer\app\Models;

use App\Models\User ;
use app\Helpers\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];
    protected $table = 'countries';

    public function user()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function states()
    {
        return $this->hasMany(State::class,'country_id');
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
            Helpers::log_admin_changes_action('delete',$model);
            $model->states()->update(['deleted_by'=>auth()->id()]);
            $model->states()->delete();
        });
    }
}
