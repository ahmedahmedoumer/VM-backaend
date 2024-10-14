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

    public function checkIn(Request $request)
    {
        $request->validate([
            'visitor_id' => 'required|uuid|exists:visitors,id',
        ]);

        $visitorLog = VisitorLog::create([
            'visitor_id' => $request->visitor_id,
            'checkin_time' => now(),
            'isAvailable' => true,
        ]);

        return response()->json($visitorLog, 201);
    }

    public function checkOut(Request $request, $id)
    {
        // Find the visitor log by ID
        $visitorLog = VisitorLog::findOrFail($id);

        // Update the checkout time and availability status
        $visitorLog->checkout_time = now();
        $visitorLog->isAvailable = false;
        $visitorLog->save();

        $propertyIds = $request->input('property_ids'); // Get property IDs from the request
        if ($propertyIds) {
            // Call the updatePropertyStatus method from the service
            $this->propertyService->updatePropertyStatus($propertyIds, false); // Assuming you want to set status to false on checkout
        }

        return response()->json($visitorLog);
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
