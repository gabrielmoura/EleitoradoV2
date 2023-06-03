<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class GroupFactory extends Factory
{
    protected $model = Group::class;

    public function definition(): array
    {
       $random_pid= Company::all()->random();

        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'tenant_id' => $random_pid->tenant_id,
            'pid' => $this->faker->uuid,
        ];
    }
}
