<?php

namespace App\Http\Controllers\VisitorLogController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VisitorLog;
use App\Services\PropertyService; // Import the PropertyService
use App\Models\Property;

class VisitorLogController extends Controller
{
    //
    protected $propertyService;

    public function __construct(PropertyService $propertyService)
    {
        $this->propertyService = $propertyService; // Inject the service
    }

    public function checkIn(Request $request,$id)
    {
        // $request->validate([
        //     'visitor_id' => 'required|uuid|exists:visitors,id',
        // ]);
        $visitorLog = VisitorLog::create([
            'visitor_id' => $id,
            'checkin_time' => now(),
            'isAvailable' => true,
        ]);
    
        // Retrieve the properties from the request
        $properties = $request->input('properties');
    
        // Loop through each property and create it using the PropertyService
        foreach ($properties as $propertyData) {
            $this->propertyService->createProperty(array_merge($propertyData, ['visitor_id' => $id]));
        }
    
        return response()->json($visitorLog, 201);
    }

    public function checkOut(Request $request)
    {
        // Validate the request to ensure it has the required visitor_id
        $request->validate([
            'visitor_id' => 'required|uuid', // Ensure the visitor ID is valid
            'property_ids' => 'array' // Optional: Validate property_ids as an array
        ]);
    
        // Create a new visitor log
        $visitorLog = VisitorLog::create([
            'visitor_id' => $request->input('visitor_id'), // Get visitor ID from the request
            'checkout_time' => now(),
            'isAvailable' => false, // Mark as not available on checkout
        ]);
    
        $propertyIds = $request->input('property_ids'); // Get property IDs from the request
        if ($propertyIds) {
            // Call the updatePropertyStatus method from the service
            $this->propertyService->updatePropertyStatus($propertyIds, false); // Update the property status as needed
        }
    
        return response()->json($visitorLog, 201); // Return the created log with a 201 status code
    }

    public function index(Request $request)
    {
        // Get the number of items per page from the request, default to 10
        $limit = $request->input('limit', 10); // Use 'limit' as the number of items per page
        $page = $request->input('page', 1); // Get the current page from the request

        // Retrieve paginated visitor logs with their associated visitors and properties
        $logs = VisitorLog::with(['visitor', 'visitor.properties'])->paginate($limit, ['*'], 'page', $page);

        return response()->json($logs);
    }
    public function show($id)
    {
        $visitorLog = VisitorLog::findOrFail($id);
        $visitor = $visitorLog->visitor; 
        return response()->json($log);
    }

    public function destroy($id)
    {
        $log = VisitorLog::findOrFail($id);
        $log->delete();

        return response()->json(null, 204);
    }

    public function updatePropertyStatus(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'property_ids' => 'required|array', // Expecting an array of property IDs
            'property_ids.*' => 'string|exists:properties,id', // Each ID should be a valid string and exist in the properties table
            'status' => 'required|boolean', // Expecting a boolean status
        ]);

        // Retrieve the property IDs from the request
        $propertyIds = $request->input('property_ids');
        $newStatus = $request->input('status');

        // Update the status of the specified properties
        Property::whereIn('id', $propertyIds)->update(['status' => $newStatus]);

        return response()->json(['message' => 'Property status updated successfully.']);
    }
}
