<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Reason;
class ReasonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Reason::class;
    public function definition()
    {
        return [
            'id' => \Illuminate\Support\Str::uuid(), // Generate UUID
            'reason' => $this->faker->sentence(), // Generate a random sentence as the reason
            'description' => $this->faker->paragraph(), // Generate a random paragraph as the description
        ];
    }
}
