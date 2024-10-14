<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // Import the User model
use App\Models\Role; // Import the Role model
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Method to create a new user
    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id', // Ensure role exists
        ]);

        $validated['password'] = Hash::make($validated['password']); // Hash the password

        $user = User::create($validated);
        return response()->json($user->load('role'), 201); // Return the user with role
    }

    // Method to retrieve all users with their roles
    public function index(Request $request) {
        // Get the number of items per page from the request, default to 10
        $perPage = $request->input('limit', 10); // Use 'limit' as the number of items per page

        // Get the current page from the request, default to 1
        $page = $request->input('page', 1);

        // Retrieve users with their roles
        $users = User::with('role')->paginate($perPage, ['*'], 'page', $page);

        return response()->json($users); // Return the paginated users
    }

    // Method to retrieve a specific user
    public function show($id) {
        return User::with('role')->findOrFail($id); // Eager load the role relationship
    }

    // Method to update a user
    public function update(Request $request, $id) {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|string|min:8|confirmed',
            'role_id' => 'sometimes|exists:roles,id', // Ensure role exists
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']); // Hash the password
        }

        $user->update($validated);
        return response()->json($user->load('role')); // Return the updated user with role
    }

    // Method to delete a user
    public function destroy($id) {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(null, 204);
    }

    // Method to assign a role to a user
    public function assignRole(Request $request, $id) {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id', // Ensure role exists
        ]);

        $user = User::findOrFail($id);
        $user->role_id = $validated['role_id']; // Assign the role ID
        $user->save(); // Save the changes

        return response()->json($user->load('role')); // Return the updated user with role
    }

    // Method to remove a role from a user
    public function removeRole(Request $request, $id) {
        $user = User::findOrFail($id);
        $user->role_id = null; // Remove the role
        $user->save(); // Save the changes

        return response()->json($user->load('role')); // Return the updated user with role
    }
}
