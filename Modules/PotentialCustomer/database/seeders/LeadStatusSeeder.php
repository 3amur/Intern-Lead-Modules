<?php

namespace Modules\PotentialCustomer\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\PotentialCustomer\app\Models\LeadStatus;

class LeadStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LeadStatus::factory()->count(20)->create();

    }
}
