<?php

namespace Modules\PotentialCustomer\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImportedCustomerDataBeforeInsert extends Model
{
    use HasFactory;

    protected $guarded=['id'];
    protected $table = 'imported_customer_new_data';


    public function potentialAccount()
    {
        return $this->belongsTo(LeadAccount::class,'potential_account_id');
    }
}
