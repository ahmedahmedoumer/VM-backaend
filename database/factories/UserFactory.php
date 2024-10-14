<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Role;
use App\Models\Company;
use Ramsey\Uuid\Uuid;
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => Uuid::uuid4()->toString(), // Generate a UUID for the primary key
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => $this->faker->optional()->dateTime(), // Optional for seeding
            'password' => bcrypt('password'), // Use bcrypt for password hashing
            'company_id' => Company::factory(), // Optionally associate with a Company
            'role_id' => Role::factory(), // Optionally associate with a Company
            'remember_token' => Str::random(10), // Generate a random remember token
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
