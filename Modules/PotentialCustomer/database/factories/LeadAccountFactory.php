<?php

namespace Modules\PotentialCustomer\database\factories;

use Modules\PotentialCustomer\app\Models\City;
use Modules\PotentialCustomer\app\Models\LeadValue;
use Modules\PotentialCustomer\app\Models\LeadSource;
use Modules\PotentialCustomer\app\Models\LeadStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\PotentialCustomer\app\Models\LeadAccount;

class LeadAccountFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\PotentialCustomer\app\Models\LeadAccount::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'account_name' => $this->faker->company,
            'account_contact_name'=>$this->faker->name,
            'lead_account_title' => $this->faker->jobTitle,
            'personal_number' => $this->faker->phoneNumber,
            'phone' => $this->faker->phoneNumber,
            'mobile' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'website' => $this->faker->url,
            'address' => $this->faker->address,
            'notes' => $this->faker->paragraph,
            'zip_code' => $this->faker->numberBetween(10000, 99999),
            'status' => $this->faker->randomElement(['active', 'inactive', 'draft']),
            'condition' => $this->faker->randomElement(['lead', 'potential']),
            'created_as' => $this->faker->randomElement(['lead', 'potential']),
            'city_id' => function () {
                return City::where('status','active')->inRandomOrder()->value('id');
            },
            'lead_source_id' => function () {
                return LeadSource::where('status','active')->inRandomOrder()->value('id');
            },
            'lead_status_id' => function () {
                return LeadStatus::where('status','active')->inRandomOrder()->value('id');
            },
            'lead_value_id' => function () {
                return LeadValue::where('status','active')->inRandomOrder()->value('id');
            },
            'sales_agent_id' => 1,
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }
}
