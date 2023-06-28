<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Company;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonFactory extends Factory
{
    protected $model = Person::class;

    public function definition(): array
    {
        $address_id = Address::all()->random()->id;
        $tenant_id = Company::all()->random()->tenant_id;

        return [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'cellphone' => $this->faker->phoneNumber,
            'telephone' => $this->faker->phoneNumber,
            'tenant_id' => $tenant_id,
            'address_id' => $address_id,
            'cpf' => $this->faker->cpf,
            'rg' => $this->faker->rg,
            'sex' => $this->faker->randomElement(['M', 'F']),
            'pid' => $this->faker->uuid,
        ];
    }
}
