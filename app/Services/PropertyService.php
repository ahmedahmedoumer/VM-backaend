<?php

namespace App\Services;

use App\Models\Property;

class PropertyService
{
    public function updatePropertyStatus(array $propertyIds, bool $newStatus)
    {
        // Update the status of the specified properties
        Property::whereIn('id', $propertyIds)->update(['status' => $newStatus]);

        return ['message' => 'Property status updated successfully.'];
    }
}