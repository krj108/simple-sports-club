<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    // Retrieve a list of all categories
    public function index()
    {
        $categories = Category::all(); // Fetch all categories from the database
        return response()->json($categories, 200); // Return categories with a 200 OK status
    }

    // Create a new category
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:categories', // Name is required, must be a string, unique in the categories table
        ]);

        // Create a new category with the validated data
        $category = Category::create($validatedData);
        // Return the created category with a 201 Created status
        return response()->json($category, 201);
    }

    // Retrieve a specific category by its ID
    public function show($id)
    {
        // Find the category by ID
        $category = Category::find($id);
        if (!$category) {
            // Return a 404 Not Found status if the category does not exist
            return response()->json(['message' => 'Category not found'], 404);
        }
        // Return the category with a 200 OK status
        return response()->json($category, 200);
    }

    // Update an existing category
    public function update(Request $request, $id)
    {
        // Find the category by ID
        $category = Category::find($id);
        if (!$category) {
            // Return a 404 Not Found status if the category does not exist
            return response()->json(['message' => 'Category not found'], 404);
        }

        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $id, // Name is required, must be a string, unique in the categories table except for the current category
        ]);

        // Update the category with the validated data
        $category->update($validatedData);
        // Return the updated category with a 200 OK status
        return response()->json($category, 200);
    }

    // Delete a category by its ID
    public function destroy($id)
    {
        // Find the category by ID
        $category = Category::find($id);
        if (!$category) {
            // Return a 404 Not Found status if the category does not exist
            return response()->json(['message' => 'Category not found'], 404);
        }

        // Delete the category
        $category->delete();
        // Return a success message with a 200 OK status
        return response()->json(['message' => 'Category deleted'], 200);
    }
}
