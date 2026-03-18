<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Visitor;

class VisitorSeeder extends Seeder
{
    public function run(): void
    {
        // Example manual seeding
        for ($i = 0; $i < 100; $i++) {
            Visitor::create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'phone' => fake()->phoneNumber(),
                'ip_address' => fake()->ipv4(),
                'visited_at' => fake()->dateTimeBetween('-30 days', 'now'),
                'created_at' => now(),
            ]);
        }
    }
}
