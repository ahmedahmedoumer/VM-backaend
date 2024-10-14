<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Company;
use App\Models\User;
use App\Models\Reason;
use App\Models\Visitor; // Ensure this line points to the correct Visitor model

class VisitorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
        protected $model = Visitor::class;
    
        public function definition()
        {
            return [
                'id' => \Illuminate\Support\Str::uuid(), // Generate UUID
                'name' => $this->faker->name(), // Random name
                'contact_number' => $this->faker->phoneNumber(), // Random phone number
                'identification_type' => $this->faker->word(), // Random identification type
                'identification_number' => $this->faker->unique()->word(), // Unique identification number
                'admin_approval' => $this->faker->boolean(), // Random boolean for approval status
                'purpose' => $this->faker->sentence(), // Random purpose of the visit
                'status' => $this->faker->randomElement(['Pending', 'Approved', 'Rejected']), // Random status
                'expected_start_date' => $this->faker->date(), // Random start date
                'expected_end_date' => $this->faker->date(), // Random end date
                // Fetch an existing company, approved user, and rejection reason, or null if not needed
                'company_id' => Company::factory(), // Create a new company and associate
                'approved_by' => User::factory(), // Create a new user and associate (or set to null if no approval)
                'rejection_reason_id' => Reason::factory(), // Create a new reason and associate (or set to null if no rejection)
            ];
        }
    }
