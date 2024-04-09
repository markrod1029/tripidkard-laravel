<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'store_code' => $this->faker->name(),
            'customer_card_num' => Str::random(8), // Random string na may 8 characters
            'fname' => $this->faker->firstName(),
            'mname' => $this->faker->lastName(), // Middle name field, maaaring hindi mo kailangan ito depende sa iyong application
            'lname' => $this->faker->lastName(),
            'contact' => $this->faker->phoneNumber(), // Random phone number
            'bdate' => $this->faker->date('Y-m-d'), // Birthday field
            'email' => $this->faker->email(),
            'zip' => $this->faker->postcode(),
            'street' => $this->faker->streetName(),
            'province' => $this->faker->state(),

        ];
    }

    /**
     * Indicate that the customer's contact is a random number.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function randomNumber(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'contact' => $this->faker->randomNumber(),
            ];
        });
    }
}
