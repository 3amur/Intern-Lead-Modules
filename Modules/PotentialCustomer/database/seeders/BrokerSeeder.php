<?php

namespace Modules\PotentialCustomer\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BrokerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('brokers')->insert([

        'name' => 'Broker 1',
        'email' => 'broker1@gmail.com',
        'phone' => '011123456789',
        'broker_type_id' => '1',
        'status' => 'active',
        'created_by' => 1,
        'created_at' => now(),
    ]);
    DB::table('brokers')->insert([

        'name' => 'Broker 2',
        'email' => 'broker2@gmail.com',
        'phone' => '011223456789',
        'broker_type_id' => '2',
        'status' => 'active',
        'created_by' => 1,
        'created_at' => now(),
    ]);
    DB::table('brokers')->insert([

        'name' => 'Broker 2',
        'email' => 'broker2@gmail.com',
        'phone' => '0122123456789',
        'broker_type_id' => '1',
        'status' => 'active',
        'created_by' => 1,
        'created_at' => now(),
    ]);
    }
}
