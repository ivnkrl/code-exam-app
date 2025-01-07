<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() {
        $user = Auth::user();
        return response()->json([
            'success'=> true,
            'message'=>'User fetched successfully',
            'data'=> $user->toArray()
        ]);
    }
    public function update(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);

            $user = Auth::user();
            
            $user = $user->update([
                'full_name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'nominated_password' => Hash::make($validatedData['password']),
                'confirmed_password' => Hash::make($validatedData['password']),
            ]);

            return response()->json(data: [
                'success'=> true,
                'message'=> 'User updated successfully',
                'data'=> $user,
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success'=> false,
                'message'=> 'An error occurred: '. $th->getMessage(),
            ], 500);
        }
    }

    public function destroy(Request $request) {
        try {
            $user = Auth::user();
            $user->delete();
            return response()->json([
                'success'=> true,
                'message'=> 'User deleted successfully',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success'=> false,
                'message'=> 'An error occurred: '. $th->getMessage(),
            ]);
        }
    }

}
