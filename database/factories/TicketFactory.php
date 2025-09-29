<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'subject' => fake()->sentence(6),
            'body' => fake()->paragraph(3),
            'status' => fake()->randomElement(['new', 'in_progress', 'resolved']),
            'answered_at' => fake()->optional()->dateTimeBetween('-1 week', 'now'),
        ];
    }
}
