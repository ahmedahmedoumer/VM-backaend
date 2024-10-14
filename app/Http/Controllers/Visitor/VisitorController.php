<?php

namespace App\Http\Controllers\Visitor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Visitor; // Import the Visitor model

class VisitorController extends Controller
{
    // Method to create a new visitor
    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:255',
            'identification_type' => 'required|string|max:255',
            'identification_number' => 'required|string|max:255',
            'purpose' => 'required|string',
            'expected_start_date' => 'required|date',
            'expected_end_date' => 'required|date',
            'company_id' => 'nullable|uuid',
            'approved_by' => 'nullable|uuid',
            'rejection_reason_id' => 'nullable|uuid',
        ]);

        $visitor = Visitor::create($validated);
        return response()->json($visitor, 201);
    }

    // Method to retrieve all visitors
    public function index(Request $request) {
        // Get the number of items per page from the request, default to 10
        $limit = $request->input('limit', 10); // Use 'limit' as the number of items per page
        $page = $request->input('page', 1);
        
        // Get the status from the request, default to 1 (approved)
        $status = $request->input('status', 1);

        // Initialize the query
        $query = Visitor::query();

        // Check the status parameter
        if ($status === 'notApproved') {
            // Filter for visitors that are not approved
            $query->where('status', '!=', "Approved"); // Corrected syntax for not equal
        } else {
            // Filter for approved visitors (default behavior)
            $query->where('status', "Approved"); // Assuming 1 means approved
        }

        // Retrieve paginated visitors based on the status
        $visitors = $query->paginate($limit, ['*'], 'page', $page);

        return response()->json($visitors); // Return the paginated visitors
    }

    // Method to retrieve a specific visitor
    public function show($id) {
        return Visitor::findOrFail($id);
    }

    // Method to update a visitor
    public function update(Request $request, $id) {
        $visitor = Visitor::findOrFail($id);
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'status' => 'sometimes|required|string|max:255',
            'contact_number' => 'sometimes|required|string|max:255',
            'identification_type' => 'sometimes|required|string|max:255',
            'identification_number' => 'sometimes|required|string|max:255',
            'purpose' => 'sometimes|required|string',
            'expected_start_date' => 'sometimes|required|date',
            'expected_end_date' => 'sometimes|required|date',
            'company_id' => 'nullable|uuid',
            'approved_by' => 'nullable|uuid',
            'rejection_reason_id' => 'nullable|uuid',
        ]);

        $visitor->update($validated);
        return response()->json($visitor);
    }

    // Method to delete a visitor
    public function destroy($id) {
        $visitor = Visitor::findOrFail($id);
        $visitor->delete();
        return response()->json(null, 204);
    }

    // Method to check in a visitor
    public function checkin($id) {
        $visitor = Visitor::findOrFail($id);
        $visitor->status = 'Checked In'; // Update status to Checked In
        $visitor->checkin_time = now(); // Assuming you have a checkin_time column
        $visitor->save();
        return response()->json($visitor);
    }

    // Method to check out a visitor
    public function checkout($id) {
        $visitor = Visitor::findOrFail($id);
        $visitor->status = 'Checked Out'; // Update status to Checked Out
        $visitor->checkout_time = now(); // Assuming you have a checkout_time column
        $visitor->save();
        return response()->json($visitor);
    }

    // Scope methods can be added here as needed
    public function scopeApproved($query) {
        return $query->where('status', 'Approved');
    }

    public function scopePending($query) {
        return $query->where('status', 'Pending');
    }

    public function scopeRejected($query) {
        return $query->where('status', 'Rejected');
    }
}
