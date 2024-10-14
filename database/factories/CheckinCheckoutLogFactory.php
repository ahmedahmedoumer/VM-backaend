<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Visitor;
use App\Models\User;


class CheckinCheckoutLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = CheckinCheckoutLog::class;

    public function definition()
    {
        return [
            'id' => \Illuminate\Support\Str::uuid(), // Generate UUID
            'visitor_id' => Visitor::factory(), // Create a new visitor and associate
            'checked_by' => User::factory(), // Create a new user and associate
            'checkin_at' => $this->faker->dateTimeBetween('-1 week', 'now'), // Random check-in time
            'checkout_at' => $this->faker->dateTimeBetween('now', '+1 week'), // Random check-out time
        ];
    }
}
