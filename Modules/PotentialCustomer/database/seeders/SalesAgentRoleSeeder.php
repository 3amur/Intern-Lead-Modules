<?php

namespace Modules\PotentialCustomer\database\seeders;

use App\Models\User ;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SalesAgentRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

            $user1 = User::create([
                'name' => 'sales',
                'email' => 'sales@gmail.com',
                'password' => Hash::make('123456789'),
                'created_by'=>'1',
            ]);

            $user2 = User::create([
                'name' => 'sales2',
                'email' => 'sales2@gmail.com',
                'password' => Hash::make('123456789'),
                'created_by'=>'1',
            ]);

            $role = Role::create([
                'name' => 'sales',
                'description' => 'Best for business owners and company administrators',
                'guard_name' => 'web',
            ]);

            $user1->assignRole($role);
            $user2->assignRole($role);
        }
}
