<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition(): array
    {
        $random_pid= Company::all()->random();
        return [
            'tenant_id' => $random_pid->tenant_id,
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'start_date' => $this->faker->dateTimeBetween('now', '+1 years'),
            'end_date' => $this->faker->dateTimeBetween('now', '+1 years'),

        ];
    }
}
