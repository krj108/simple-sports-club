<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    // Constructor applies the 'auth:api' middleware to all methods
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    // Retrieve a list of all rooms
    public function index()
    {
        return Room::all();
    }

    // Store a new room in the database
    public function store(Request $request)
    {
        // Create a new room using request data
        $room = Room::create($request->all());
        return response()->json($room, 201);  // Return the created room with a 201 status code
    }

    // Retrieve a specific room by its ID
    public function show(Room $room)
    {
        return $room;
    }

    // Update an existing room in the database
    public function update(Request $request, Room $room)
    {
        $room->update($request->all());  // Update the room with the request data
        return response()->json($room, 200);  // Return the updated room with a 200 status code
    }

    // Delete a specific room from the database
    public function destroy(Room $room)
    {
        $room->delete();  // Delete the room
        return response()->json(null, 204);  // Return a 204 status code with no content
    }
}
