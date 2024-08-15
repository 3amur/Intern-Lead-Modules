<?php

namespace Modules\PotentialCustomer\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TargetTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('target_types')->insert([
            [
                'title' => 'targetType1',
                'created_by'=>1,
                'created_at' => now(),
            ],
            [
                'title' => 'targetType2',
                'created_by'=>1,
                'created_at' => now(),
            ],
            [
                'title' => 'targetType3',
                'created_by'=>1,
                'created_at' => now(),
            ]
        ]);
    }
}
