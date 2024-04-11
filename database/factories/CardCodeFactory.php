<?php

namespace Database\Factories;

use App\Models\CardCode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\card_code>
 */
class CardCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->create()->id,
            'store_code' => $this->faker->name(),
            'card_number' => $this->faker->name(),
            'status' => rand(1, 3),

        ];


    }
}
