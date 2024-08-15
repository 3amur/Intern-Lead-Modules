<?php

namespace Modules\PotentialCustomer\app\Models;

use App\Models\User;
use app\Helpers\Helpers;
use Illuminate\Database\Eloquent\Model;
use Modules\Reminder\app\Models\Reminder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\PotentialCustomer\app\Models\City;
use Modules\PotentialCustomer\app\Models\State;
use Modules\PotentialCustomer\app\Models\Country;
use Modules\PotentialCustomer\app\Models\LeadType;
use Modules\PotentialCustomer\app\Models\LeadValue;
use Modules\PotentialCustomer\app\Models\LeadSource;
use Modules\PotentialCustomer\app\Models\LeadStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\PotentialCustomer\database\factories\LeadAccountFactory;

class LeadAccount extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    protected $table = 'lead_accounts';

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function salesAgent()
    {
        return $this->belongsTo(User::class, 'sales_agent_id');
    }
    public function leadSource()
    {
        return $this->belongsTo(LeadSource::class);
    }

    public function leadStatus()
    {
        return $this->belongsTo(LeadStatus::class);
    }

    public function leadValue()
    {
        return $this->belongsTo(LeadValue::class);
    }

    public function leadType()
    {
        return $this->belongsTo(LeadType::class);
    }


    /* public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    } */

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function leadTransition()
    {
        return $this->hasMany(LeadTransition::class, 'account_id');
    }

    public function links()
    {
        return $this->hasMany(Link::class, 'account_id');
    }

    public function familyMembers()
    {
        return $this->hasMany(FamilyMember::class, 'potential_account_id');
    }
    public function headMembers()
    {
        return $this->hasMany(HeadFamilyMember::class, 'potential_account_id');
    }


    public function importedData()
    {
        return $this->hasMany(ImportedCustomerData::class, 'potential_account_id', 'id');
    }

    public function reminders()
    {
        return $this->hasMany(Reminder::class, 'lead_id');
    }

    public function potentialAccountDetails()
    {
        return $this->hasOne(PotentialAccountDetails::class, 'potential_account_id');
    }

    protected static function newFactory(): LeadAccountFactory
    {
        return LeadAccountFactory::new();
    }

    protected static function boot()
    {
        parent::boot();
        static::updated(function ($model) {
            Helpers::log_admin_changes_action('update', $model);
        });
        static::created(function ($model) {
            Helpers::log_admin_changes_action('create', $model);

                    PotentialAccountDetails::create([
                        'potential_account_id'=>$model->id,
                        'created_by'=> auth()->id() ?  auth()->id() : 1
                    ]);

        });
        static::deleted(function ($model) {
            if (!$model->trashed()) {
                Helpers::log_admin_changes_action('delete', $model);
            }
        });
    }

}
