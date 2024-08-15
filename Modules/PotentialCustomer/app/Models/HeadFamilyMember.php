<?php

namespace Modules\PotentialCustomer\app\Models;

use App\Models\User ;
use app\Helpers\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\PotentialCustomer\app\Models\Link;
use Modules\PotentialCustomer\app\Models\MemberFile;
use Modules\PotentialCustomer\app\Models\LeadAccount;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HeadFamilyMember extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded = ['id'];
    protected $table = 'head_family_members';
    public function user()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function potentialAccount()
    {
        return $this->belongsTo(LeadAccount::class,'potential_account_id');
    }

    public function headFiles()
    {
        return $this->hasMany(MemberFile::class,'head_member_id','id');
    }

    public function familyMembers()
    {
        return $this->hasMany(FamilyMember::class,'head_member_id','id');
    }
    public function link()
    {
        return $this->belongsTo(Link::class,'link_id');

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
