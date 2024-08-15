<?php

namespace Modules\PotentialCustomer\database\seeders;

use Illuminate\Database\Seeder;
use Modules\PotentialCustomer\database\seeders\TeamSeeder;
use Modules\PotentialCustomer\database\seeders\BrokerSeeder;
use Modules\PotentialCustomer\database\seeders\CitiesSeeder;
use Modules\PotentialCustomer\database\seeders\StatesSeeder;
use Modules\PotentialCustomer\database\seeders\LeadTypeSeeder;
use Modules\PotentialCustomer\database\seeders\CountriesSeeder;
use Modules\PotentialCustomer\database\seeders\LeadValueSeeder;
use Modules\PotentialCustomer\database\seeders\BrokerTypeSeeder;
use Modules\PotentialCustomer\database\seeders\DepartmentSeeder;
use Modules\PotentialCustomer\database\seeders\LeadSourceSeeder;
use Modules\PotentialCustomer\database\seeders\LeadStatusSeeder;
use Modules\PotentialCustomer\database\seeders\TargetTypeSeeder;
use Modules\PotentialCustomer\database\seeders\LeadAccountSeeder;
use Modules\PotentialCustomer\database\seeders\SalesAgentRoleSeeder;
use Modules\PotentialCustomer\database\seeders\PotentialAccountSeeder;
use Modules\PotentialCustomer\database\seeders\RolesAndPermissionsSeeder;
use Modules\PotentialCustomer\database\seeders\CountryEgyptActivationSeeder;



class PotentialCustomerDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            CountriesSeeder::class,
            StatesSeeder::class,
            CitiesSeeder::class,
            LeadSourceSeeder::class,
            LeadStatusSeeder::class,
            LeadTypeSeeder::class,
            LeadValueSeeder::class,
            CountryEgyptActivationSeeder::class,
            LeadAccountSeeder::class,
            SalesAgentRoleSeeder::class,
            TargetTypeSeeder::class,
            BrokerTypeSeeder::class,
            BrokerSeeder::class,
            DepartmentSeeder::class,
            TeamSeeder::class,
        ]);
    }
}
