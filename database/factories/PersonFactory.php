<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Company;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PersonFactory extends Factory
{
    protected $model = Person::class;

    public function definition(): array
    {
        $address_id=Address::all()->random()->id;
        $tenant_id = Company::all()->random()->tenant_id;
        return [
            'tenant_id' => $tenant_id,
            'pid'=> $this->faker->uuid(),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'cpf' => $this->faker->word(),
            'rg' => $this->faker->word(),
            'address_id' => $address_id,
        ];
    }
}
