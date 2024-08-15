<?php

namespace Modules\PotentialCustomer\app\Models;

use App\Models\User ;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeadAccountImport extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $table = 'lead_account_import';


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
}
