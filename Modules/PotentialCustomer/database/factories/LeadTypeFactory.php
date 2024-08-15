<?php

namespace Modules\PotentialCustomer\database\factories;

use Modules\PotentialCustomer\app\Models\LeadType;
use Illuminate\Database\Eloquent\Factories\Factory;


class LeadTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */


         /**
     * The name of the factory's corresponding model.
     */
    protected $model = LeadType::class;
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
