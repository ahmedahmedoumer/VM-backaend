<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Role;
use App\Models\Permission;
use App\Models\RolePermission;

class RolePermissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = RolePermission::class;

    public function definition()
    {
        return [
            'id' => \Illuminate\Support\Str::uuid(), // Generate UUID
            'role_id' => Role::factory(), // Create a new role and associate
            'permission_id' => Permission::factory(), // Create a new permission and associate
        ];
    }
}
