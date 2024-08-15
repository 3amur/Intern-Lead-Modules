<?php

namespace Modules\PotentialCustomer\database\seeders;

use Illuminate\Database\Seeder;
use Modules\PotentialCustomer\app\Models\LeadType;


class LeadTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LeadType::factory()->count(20)->create();
    }
}
