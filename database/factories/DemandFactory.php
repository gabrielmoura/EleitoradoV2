<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Demand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DemandFactory extends Factory
{
    protected $model = Demand::class;

    public function definition(): array
    {
        $random = Company::all()->random();

        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'tenant_id' => $random->tenant_id,
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'demand_type_id' => $this->faker->randomElement([1, 2, 3, 4, 5]),
        ];
    }
}
