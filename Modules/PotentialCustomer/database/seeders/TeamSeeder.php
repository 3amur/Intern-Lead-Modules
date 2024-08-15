<?php

namespace Modules\PotentialCustomer\database\seeders;

use Illuminate\Database\Seeder;
use Modules\PotentialCustomer\app\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Team::create([
            'title' => 'Sales Team 1',
            'department_id' => 1,
            'created_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Team::create([
            'title' => 'Sales Team 2',
            'department_id' => 1,
            'created_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Team::create([
            'title' => 'Marketing Team 1',
            'department_id' => 2,
            'created_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Team::create([
            'title' => 'Human Resource Team',
            'department_id' => 3,
            'created_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

