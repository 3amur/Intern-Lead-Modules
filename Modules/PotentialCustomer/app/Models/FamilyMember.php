<?php

namespace Modules\PotentialCustomer\app\Models;

use App\Models\User ;
use app\Helpers\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FamilyMember extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id'];
    protected $table = 'family_members';
    public function user()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function potentialAccount()
    {
        return $this->belongsTo(LeadAccount::class,'potential_account_id');
    }


    public function headFamilyMember()
    {
        return $this->belongsTo(HeadFamilyMember::class,'potential_account_id');
    }


    public function familyMemberFiles()
    {
        return $this->hasMany(MemberFile::class,'family_member_id','id');
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
