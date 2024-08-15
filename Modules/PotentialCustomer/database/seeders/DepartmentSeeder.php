<?php

namespace Modules\PotentialCustomer\database\seeders;

use Illuminate\Database\Seeder;
use Modules\PotentialCustomer\app\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::create([
            'title' => 'Sales',
            'created_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Department::create([
            'title' => 'Marketing',
            'created_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Department::create([
            'title' => 'Human Resource (HR)',
            'created_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
