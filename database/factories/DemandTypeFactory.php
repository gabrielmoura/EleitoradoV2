<?php

namespace Database\Factories;

use App\Models\DemandType;
use Illuminate\Database\Eloquent\Factories\Factory;

class DemandTypeFactory extends Factory
{
    protected $model = DemandType::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'responsible' => $this->faker->name,
        ];
    }
}
