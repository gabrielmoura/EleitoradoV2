<?php

namespace Database\Factories;

use App\Models\DirectMail;
use Illuminate\Database\Eloquent\Factories\Factory;

class DirectMailFactory extends Factory
{
    protected $model = DirectMail::class;

    public function definition(): array
    {
        return [
            'person_id' => $this->faker->numberBetween(1, 100),
            'tenant_id' => $this->faker->numberBetween(1, 100),
            'received' => $this->faker->boolean,
            'want_to_receive' => $this->faker->boolean,
            'vote' => $this->faker->boolean,
            'know_a_proposal' => $this->faker->boolean,
            'indicate' => $this->faker->boolean,
        ];
    }
}
