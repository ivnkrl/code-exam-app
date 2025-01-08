<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|confirmed|string|min:8',
            'role_name' => 'required|string|max:255',
            'role_description' => 'required|string|max:255',
        ]);

        $user = User::create([
            'full_name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'nominated_password' => Hash::make($validatedData['password']),
            'confirmed_password' => Hash::make($validatedData['password']),
        ]);

        $user->role()->create([
            'role_name' => $validatedData['role_name'],
             'description'=> $validatedData['role_description'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User registered successfully'
        ], 201);        
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        
        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->confirmed_password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user, 'role' => $user->role], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully'], 200);
    }
}
