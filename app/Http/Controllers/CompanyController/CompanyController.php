<?php

namespace App\Http\Controllers\CompanyController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    //

     // Method to create a new company
     public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:255',
        ]);

        $company = Company::create($validated);
        return response()->json($company, 201);
    }

    // Method to retrieve all companies
    public function index() {
        return Company::all();
    }

    // Method to retrieve a specific company
    public function show($id) {
        return Company::findOrFail($id);
    }

    public function update(Request $request, $id) {
        $company = Company::findOrFail($id);
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'address' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:255',
        ]);

        $company->update($validated);
        return response()->json($company);
    }

    // Method to delete a company
    public function destroy($id) {
        $company = Company::findOrFail($id);
        $company->delete();
        return response()->json(null, 204);
    }


}
