<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    // Retrieve a list of all tags
    public function index()
    {
        // Fetch all tags from the database and return them
        $tags = Tag::all();
        return response()->json($tags, 200);
    }

    // Create a new tag
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:tags',
        ]);

        // Create a new tag with the validated data
        $tag = Tag::create($validatedData);
        // Return the created tag with a 201 Created status
        return response()->json($tag, 201);
    }

    // Retrieve a specific tag by its ID
    public function show($id)
    {
        // Find the tag by its ID
        $tag = Tag::find($id);
        if (!$tag) {
            // If the tag is not found, return a 404 Not Found response
            return response()->json(['message' => 'Tag not found'], 404);
        }
        // Return the found tag with a 200 OK status
        return response()->json($tag, 200);
    }

    // Update an existing tag by its ID
    public function update(Request $request, $id)
    {
        // Find the tag by its ID
        $tag = Tag::find($id);
        if (!$tag) {
            // If the tag is not found, return a 404 Not Found response
            return response()->json(['message' => 'Tag not found'], 404);
        }

        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:tags,name,' . $id,
        ]);

        // Update the tag with the validated data
        $tag->update($validatedData);
        // Return the updated tag with a 200 OK status
        return response()->json($tag, 200);
    }

    // Delete a specific tag by its ID
    public function destroy($id)
    {
        // Find the tag by its ID
        $tag = Tag::find($id);
        if (!$tag) {
            // If the tag is not found, return a 404 Not Found response
            return response()->json(['message' => 'Tag not found'], 404);
        }

        // Delete the tag
        $tag->delete();
        // Return a message indicating successful deletion with a 200 OK status
        return response()->json(['message' => 'Tag deleted'], 200);
    }
}
