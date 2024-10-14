<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Visitor;
use App\Models\Property;
use App\Models\Reason;
use App\Models\CheckinCheckoutLog;
use App\Models\Company;
use App\Models\Permission;
use App\Models\Role;
use App\Models\RolePermission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();

        // Company::factory()->count(10)->create();
        // // Create Users
        // User::factory()->count(10)->create();

        // // Create Reasons
        // Reason::factory()->count(10)->create();

        // Create Properties
        Property::factory()->count(20)->create();

        // // Create Visitors
        // Visitor::factory()->count(10)->create();

        // // Create Checkin and Checkout Logs
        // CheckinCheckoutLog::factory()->count(30)->create();

        // Create Permissions
        // Permission::factory()->count(10)->create();

        // // Create Roles
        // Role::factory()->count(5)->create();

        // RolePermission::factory()->count(10)->create();
    }
}
