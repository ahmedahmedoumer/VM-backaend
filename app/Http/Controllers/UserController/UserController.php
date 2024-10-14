<?php

namespace App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property; // Import the Property model

class UserController extends Controller
{
    //


 // Method to create a new user
 public function store(Request $request) {
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'nullable|string|max:50',
    ]);

    $validated['password'] = Hash::make($validated['password']); // Hash the password

    $user = User::create($validated);
    return response()->json($user, 201);
}

// Method to retrieve all users
public function index() {
    return User::all();
}

// Method to retrieve a specific user
public function show($id) {
    return User::findOrFail($id);
}


   // Method to update a user
   public function update(Request $request, $id) {
    $user = User::findOrFail($id);
    $validated = $request->validate([
        'name' => 'sometimes|required|string|max:255',
        'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
        'password' => 'sometimes|required|string|min:8|confirmed',
        'role' => 'nullable|string|max:50',
    ]);

    if (isset($validated['password'])) {
        $validated['password'] = Hash::make($validated['password']); // Hash the password
    }

    $user->update($validated);
    return response()->json($user);
}

// Method to delete a user
public function destroy($id) {
    $user = User::findOrFail($id);
    $user->delete();
    return response()->json(null, 204);
}

// Scope methods for filtering users
public function scopeWithRole($query, $role) {
    return $query->where('role', $role);
}


}
