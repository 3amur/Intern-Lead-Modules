<?php

namespace Modules\Reminder\app\Models;

use App\Models\User;
use app\Helpers\Helpers;
use Modules\Reminder\app\Models\Phone;
use Illuminate\Database\Eloquent\Model;
use Modules\Reminder\app\Models\Reminder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    protected $table = 'contacts';

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function reminders()
    {
        return $this->belongsToMany(Reminder::class,'reminders_contacts','contact_id','reminder_id');
    }

    public function phones()
    {
        return $this->hasMany(Phone::class, 'contact_id','id');
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
