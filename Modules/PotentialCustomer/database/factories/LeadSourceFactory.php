<?php

namespace Modules\PotentialCustomer\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\PotentialCustomer\app\Models\LeadSource;

class LeadSourceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = LeadSource::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(['active', 'inactive', 'draft']),
            'created_by' => 1,
            'updated_by' => 1,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}

