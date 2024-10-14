<?php

namespace Database\Factories;

use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

class PropertyFactory extends Factory
{
    protected $model = Property::class;

    public function definition()
    {
        return [
            'id' => \Illuminate\Support\Str::uuid(), // Generate UUID
            'visitor_id' => \App\Models\Visitor::factory(), // Assuming Visitor factory exists
            'property_name' => $this->faker->word(),
            'property_type' => $this->faker->word(),
            'property_status' => $this->faker->randomElement(['Pending', 'Approved', 'Rejected']), // Random status
            'description' => $this->faker->sentence(),
            'quantity' => $this->faker->numberBetween(1, 10), // Random quantity between 1 and 10
        ];
    }
}
