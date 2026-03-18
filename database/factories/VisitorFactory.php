<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Visitor>
 */
class VisitorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
    'name' => $this->faker->name,
    'email' => $this->faker->safeEmail,
    'phone' => $this->faker->phoneNumber,
    'ip_address' => $this->faker->ipv4,
    'country' => $this->faker->country,
    'city' => $this->faker->city,
    'user_agent' => $this->faker->userAgent,
    'visited_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
];
    }
}
