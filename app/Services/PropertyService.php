<?php

namespace App\Services;

use App\Models\Property;

class PropertyService
{
    public function updatePropertyStatus(array $propertyIds, bool $newStatus)
    {
        // Update the status of the specified properties
        Property::whereIn('id', $propertyIds)->update(['property_status' => $newStatus]);

        return ['message' => 'Property status updated successfully.'];
    }

    public function createProperty(array $data)
    {
        // Validate and create a new property
        $property = Property::create([
            'id' => $data['id'] ?? \Str::uuid(), // Generate a UUID if not provided
            'visitor_id' => $data['owner'] ?? null,
            'property_name' => $data['property_name'],
            'property_type' => $data['property_type'] ?? "default",
            'property_status' => $data['status'] ?? 'available',
            'description' => $data['description'] ?? null,
            'quantity' => $data['quantity'] ?? 1,
        ]);

        return $property;
    }
}