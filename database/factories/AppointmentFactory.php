<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AppointmentFactory extends Factory
{
    protected $model = Appointment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'pid' => $this->faker->word(),
            'tenant_id' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'end_time' => Carbon::now(),
            'start_time' => Carbon::now(),
            'recurrence' => $this->faker->word(),
            'properties' => $this->faker->word(),
            'event_id' => $this->faker->randomNumber(),

            'appointment_id' => Appointment::factory(),
            'address_id' => Address::factory(),
        ];
    }
}
