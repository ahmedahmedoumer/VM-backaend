<?php

namespace App\Http\Controllers\PropertyController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    //


    public function store(Request $request) {
        $validated = $request->validate([
            'visitor_id' => 'nullable|uuid|exists:visitors,id', // Ensure visitor exists
            'property_name' => 'required|string|max:255',
            'property_type' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $property = Property::create($validated);
        return response()->json($property, 201);
    }

    // Method to retrieve all properties
    public function index() {
        return Property::with('visitor')->get(); // Eager load visitor relationship
    }

    // Method to retrieve a specific property
    public function show($id) {
        return Property::with('visitor')->findOrFail($id); // Eager load visitor relationship
    }

    // Method to update a property
    public function update(Request $request, $id) {
        $property = Property::findOrFail($id);
        $validated = $request->validate([
            'visitor_id' => 'nullable|uuid|exists:visitors,id', // Ensure visitor exists
            'property_name' => 'sometimes|required|string|max:255',
            'property_type' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'quantity' => 'sometimes|required|integer|min:1',
        ]);

        $property->update($validated);
        return response()->json($property);
    }

     // Method to delete a property
     public function destroy($id) {
        $property = Property::findOrFail($id);
        $property->delete();
        return response()->json(null, 204);
    }

}
