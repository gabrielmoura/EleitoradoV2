<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition(): array
    {
        $tenant_id = Company::all()->random()->tenant_id;

        return [
            'tenant_id' => $tenant_id,
            'street' => $this->faker->streetName(),
            'number' => $this->faker->buildingNumber(),
            'complement' => $this->faker->currencyCode(),
            'district' => $this->faker->city(),
            'city' => $this->faker->city(),
            'state' => $this->faker->city(),
            'uf' => $this->faker?->stateAbbr(),
            'country' => 'BR',
            'zipcode' => $this->faker->postcode(),
            'processed_at' => now(),
        ];
    }
}
