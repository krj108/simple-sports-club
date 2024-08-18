<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // Retrieve all articles
    public function index()
    {
        return response()->json(Article::all(), 200);
    }

    // Retrieve a specific article by its ID
    public function show($id)
    {
        $article = Article::find($id);
        if (!$article) {
            // Return a 404 error if the article is not found
            return response()->json(['message' => 'Article not found'], 404);
        }
        // Return the article data with a 200 status code
        return response()->json($article, 200);
    }

    // Create a new article
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255', // Title must be a string and cannot exceed 255 characters
            'content' => 'required|string', // Content must be a string
            'category_id' => 'required|integer|exists:categories,id', // Category ID must be an integer and exist in the categories table
            'tags' => 'array', // Tags should be an array
            'tags.*' => 'string', // Each tag in the array should be a string
            'media' => 'nullable|file|mimes:jpeg,png,jpg,mp4,mov|max:20480', // Media file is optional; should be an image or video file with max size 20MB
        ]);

        // Create a new article with the validated data
        $article = Article::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'category_id' => $validatedData['category_id'],
        ]);

        // Upload the media file if provided
        if ($request->hasFile('media')) {
            $path = $request->file('media')->store('public/media'); // Store the media file and get its path
            $article->media_path = $path; // Set the media path in the article
            $article->save(); // Save the article with the media path
        }

        // Attach tags to the article if provided
        if (isset($validatedData['tags'])) {
            $article->tags()->sync($validatedData['tags']); // Sync the tags with the article
        }

        // Return the created article with a 201 status code
        return response()->json($article, 201);
    }

    // Update an existing article by its ID
    public function update(Request $request, $id)
    {
        $article = Article::find($id);
        if (!$article) {
            // Return a 404 error if the article is not found
            return response()->json(['message' => 'Article not found'], 404);
        }

        // Validate the incoming request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255', // Title must be a string and cannot exceed 255 characters
            'content' => 'required|string', // Content must be a string
            'category_id' => 'required|integer|exists:categories,id', // Category ID must be an integer and exist in the categories table
            'tags' => 'array', // Tags should be an array
            'tags.*' => 'string', // Each tag in the array should be a string
            'media' => 'nullable|file|mimes:jpeg,png,jpg,mp4,mov|max:20480', // Media file is optional; should be an image or video file with max size 20MB
        ]);

        // Update the article with the validated data
        $article->update([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'category_id' => $validatedData['category_id'],
        ]);

        // Update the media file if provided
        if ($request->hasFile('media')) {
            $path = $request->file('media')->store('public/media'); // Store the media file and get its path
            $article->media_path = $path; // Set the media path in the article
            $article->save(); // Save the article with the media path
        }

        // Update the tags associated with the article
        if (isset($validatedData['tags'])) {
            $article->tags()->sync($validatedData['tags']); // Sync the tags with the article
        }

        // Return the updated article with a 200 status code
        return response()->json($article, 200);
    }

    // Delete an article by its ID
    public function destroy($id)
    {
        $article = Article::find($id);
        if (!$article) {
            // Return a 404 error if the article is not found
            return response()->json(['message' => 'Article not found'], 404);
        }

        // Delete the article
        $article->delete();

        // Return a success message with a 200 status code
        return response()->json(['message' => 'Article deleted'], 200);
    }
}
