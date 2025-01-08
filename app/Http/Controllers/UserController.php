<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\ValidationException;
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
        $user = Auth::user();

        $validatedData = $request->validate([
            'full_name' => 'required|string|max:255|unique:users,full_name,' . $user->id,
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
        ]);
        
        $user = $user->update([
            'full_name' => $validatedData['full_name'],
            'email' => $validatedData['email'],
        ]);
        
        return response()->json(data: [
            'success'=> true,
            'message'=> 'User updated successfully',
            'data'=> Auth::user()->toArray(),
        ]);
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

    public function updatePassword(Request $request) 
    {    
        $validatedData = $request->validate([
            'password_old' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
        ]);

        $user = Auth::user();
        
        if (!$user || !Hash::check($validatedData['password_old'], $user->confirmed_password)) {
            throw ValidationException::withMessages([
                'password_old' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user->nominated_password = Hash::make($validatedData['password']);
        $user->confirmed_password = Hash::make($validatedData['password']);

        $user->save();

        return response()->json([
            'success'=> true,
            'message'=> 'Password changed successfully',
        ]);

    }

}


