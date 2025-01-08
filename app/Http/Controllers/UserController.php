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

}


