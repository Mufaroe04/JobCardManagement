<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\View\View; // Add this import

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View // Change the return type hint to View
    {
        $users = User::all(); // Fetch all users from the database
        return view('admin.users', compact('users')); // Load the view and pass the users data
    }


    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'is_admin' => 'boolean', // Validate is_admin
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Validation error',
            ], 422);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'is_admin' => $request->input('is_admin', false), // Get is_admin from request
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully',
            'token' => $token,
            'user' => $user,
        ], 201);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->only('email', 'password');

        $validator = Validator::make($credentials, [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Validation error',
            ], 422);
        }

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Revoke existing tokens...  Important for single-session control
            $user->tokens()->delete();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user,
            ], 200);
        }

        return response()->json([
            'message' => 'Invalid login credentials',
        ], 401);
    }

    /**
     * Handle a logout request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $user = Auth::user();
        //Revoke the current token.
        $user->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully',
        ], 200);
    }

    public function toggleAdmin(Request $request, $id)
    {
        $user = User::findOrFail($id);
    
        //  No need to check for is_admin here, since we're allowing any logged-in user to change it for this test.
    
        // Prevent admin from removing himself
        if (Auth::user()->id == $user->id) {
            return redirect()->route('users.index')->with('error', 'You cannot change your own admin status.');
        }
    
        $user->is_admin = !$user->is_admin; // Toggle the admin status
        $user->save();
    
        return redirect()->route('users.index')->with('success', 'User role updated successfully.');
    }
    
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
