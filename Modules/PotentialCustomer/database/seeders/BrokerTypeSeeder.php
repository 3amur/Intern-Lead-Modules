<?php

namespace Modules\PotentialCustomer\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BrokerTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('broker_types')->insert([
            'title'=>'Broker Type 1',
            'description'=>'Broker Type for Testing (Dummy Data)',
            'status'=>'active',
            'created_by'=>1,
            'created_at'=>now(),
            'updated_at'=>now(),

        ]);
        DB::table('broker_types')->insert([
            'title'=>'Broker Type 2',
            'description'=>'Broker Type for Testing (Dummy Data)',
            'status'=>'active',
            'created_by'=>1,
            'created_at'=>now(),
            'updated_at'=>now(),

        ]);
         DB::table('broker_types')->insert([
            'title'=>'Broker Type 3',
            'description'=>'Broker Type for Testing (Dummy Data)',
            'status'=>'active',
            'created_by'=>1,
            'created_at'=>now(),
            'updated_at'=>now(),

        ]);
    }
}
