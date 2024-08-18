<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    // Apply authentication middleware for all methods in this controller
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    // Retrieve a list of all facilities
    public function index()
    {
        // Fetch all facilities from the database and return them
        return Facility::all();
    }

    // Create a new facility
    public function store(Request $request)
    {
        // Create a new facility with the request data
        $facility = Facility::create($request->all());
        // Return the created facility with a 201 Created status
        return response()->json($facility, 201);
    }

    // Retrieve a specific facility by its ID
    public function show(Facility $facility)
    {
        // Return the specified facility
        return $facility;
    }

    // Update an existing facility
    public function update(Request $request, Facility $facility)
    {
        // Update the facility with the request data
        $facility->update($request->all());
        // Return the updated facility with a 200 OK status
        return response()->json($facility, 200);
    }

    // Delete a specific facility
    public function destroy(Facility $facility)
    {
        // Delete the specified facility
        $facility->delete();
        // Return a 204 No Content status
        return response()->json(null, 204);
    }
}
