<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    // Register a new user
    public function register(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255', // Name is required, must be a string and cannot exceed 255 characters
            'email' => 'required|string|email|max:255|unique:users', // Email is required, must be a valid email format, and unique in the users table
            'password' => 'required|string|min:8|confirmed', // Password is required, must be at least 8 characters long, and confirmed
        ]);

        // Create a new user with the validated data
        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']), // Encrypt the password before storing
        ]);

        // Generate a JWT token for the newly created user
        $token = JWTAuth::fromUser($user);

        // Return the token with a 201 status code
        return response()->json(['token' => $token], 201);
    }

    // Log in an existing user
    public function login(Request $request)
    {
        // Validate the incoming login credentials
        $credentials = $request->validate([
            'email' => 'required|string|email', // Email is required and must be a valid email format
            'password' => 'required|string', // Password is required
        ]);

        try {
            // Attempt to log in the user and generate a JWT token
            if (!$token = JWTAuth::attempt($credentials)) {
                // Return a 401 status code if credentials are invalid
                return response()->json(['message' => 'Unauthorized'], 401);
            }
        } catch (JWTException $e) {
            // Return a 500 status code if there is an issue creating the token
            return response()->json(['message' => 'Could not create token'], 500);
        }

        // Return the token with a 200 status code if successful
        return response()->json(['token' => $token], 200);
    }

    // Log out the user
    public function logout(Request $request)
    {
        // Invalidate the JWT token to log the user out
        JWTAuth::invalidate($request->bearerToken());
        // Return a success message with a 200 status code
        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
