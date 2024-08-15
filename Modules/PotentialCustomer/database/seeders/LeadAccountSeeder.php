<?php

namespace Modules\PotentialCustomer\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\PotentialCustomer\app\Models\TargetType;
use Modules\PotentialCustomer\app\Models\LeadAccount;

class LeadAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        TargetType::create([
            'title'=>'test seed lead accounts time (beginning)'
        ]);
        LeadAccount::factory()->count(200)->create();

        TargetType::create([
            'title'=>'test seed lead accounts time (End)'
        ]);
    }
}
