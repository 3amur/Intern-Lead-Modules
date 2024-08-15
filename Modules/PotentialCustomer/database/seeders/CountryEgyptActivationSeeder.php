<?php

namespace Modules\PotentialCustomer\database\seeders;

use Illuminate\Database\Seeder;
use Modules\PotentialCustomer\app\Models\City;
use Modules\PotentialCustomer\app\Models\State;
use Modules\PotentialCustomer\app\Models\Country;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CountryEgyptActivationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $country = Country::where('name', 'Egypt')->first();


        if ($country) {
            $states = State::where('country_id', $country->id)->get();
            $stateIds = $states->pluck('id');
            $cities = City::whereIn('state_id', $stateIds)->get();
            $country->update([
                'status' => 'active',
            ]);
            $states->each(function ($state) {
                $state->update([
                    'status' => 'active',
                ]);
            });
            $cities->each(function ($city) {
                $city->update([
                    'status' => 'active',
                ]);
            });
        }
    }

}
