<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Sport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SportController extends Controller
{
    // Constructor applies the 'auth:api' middleware to all methods
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    // Retrieve a list of all sports
    public function index()
    {
        return Sport::all();
    }

    // Create a new sport
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'videos' => 'nullable|array',
            'videos.*' => 'mimes:mp4,mov,ogg,qt|max:20000',
            'days' => 'nullable|array',
            'days.*' => 'in:Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday,Friday',
        ]);

        // Handle image uploads
        $imagePaths = [];
        if ($request->has('images')) {
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('sports/images', 'public');
            }
        }

        // Handle video uploads
        $videoPaths = [];
        if ($request->has('videos')) {
            foreach ($request->file('videos') as $video) {
                $videoPaths[] = $video->store('sports/videos', 'public');
            }
        }

        // Create a new sport record in the database
        $sport = Sport::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'] ?? '',
            'images' => json_encode($imagePaths),
            'videos' => json_encode($videoPaths),
            'days' => json_encode($validatedData['days'] ?? []),
        ]);

        return response()->json($sport, 201);  // Return the created sport with a 201 status code
    }

    // Retrieve a specific sport by its ID
    public function show(Sport $sport)
    {
        return $sport;
    }

    // Update an existing sport
    public function update(Request $request, Sport $sport)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'videos' => 'nullable|array',
            'videos.*' => 'mimes:mp4,mov,ogg,qt|max:20000',
            'days' => 'nullable|array',
            'days.*' => 'in:Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday,Friday',
        ]);

        // Handle updating images if provided
        if ($request->has('images')) {
            $imagePaths = [];
            foreach ($request->file('images') as $image) {
                $imagePaths[] = $image->store('sports/images', 'public');
            }
            $sport->images = json_encode($imagePaths);
        }

        // Handle updating videos if provided
        if ($request->has('videos')) {
            $videoPaths = [];
            foreach ($request->file('videos') as $video) {
                $videoPaths[] = $video->store('sports/videos', 'public');
            }
            $sport->videos = json_encode($videoPaths);
        }

        // Update other sport data
        $sport->update([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'] ?? $sport->description,
            'days' => json_encode($validatedData['days'] ?? json_decode($sport->days)),
        ]);

        return response()->json($sport, 200);  // Return the updated sport with a 200 status code
    }

    // Delete a specific sport
    public function destroy(Sport $sport)
    {
        // Delete associated images from storage
        foreach (json_decode($sport->images) as $image) {
            Storage::disk('public')->delete($image);
        }

        // Delete associated videos from storage
        foreach (json_decode($sport->videos) as $video) {
            Storage::disk('public')->delete($video);
        }

        // Delete the sport from the database
        $sport->delete();

        return response()->json(null, 204);  // Return a 204 status code with no content
    }
}
