<?php

namespace Database\Factories;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignFactory extends Factory
{
    protected $model = Campaign::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'tenant_id' => $this->faker->uuid,
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(10),
            'message' => $this->faker->sentence(10),
            'status' => $this->faker->randomElement(['draft', 'published']),
            'url' => $this->faker->url,
            'attachment' => $this->faker->imageUrl(640, 480, 'cats', true, 'Faker', true),
            'direct_mail_id' => null,
        ];
    }
}
