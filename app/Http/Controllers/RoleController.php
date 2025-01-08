<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User is not authenticated.',
                ], 401);
            }

            $role = $user->role()->first();

            if (!$role) {
                return response()->json([
                    'success' => false,
                    'message' => 'User has no role.',
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Success',
                'data' => $role,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred',
            ], 500);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            
            $validatedData = $request->validate([
                'role_name' => 'required|string|max:255',
                'description' => 'required|string|max:255',
            ]);

            if (Auth::user()->role()->exists()) {
                return response()->json([
                    'success'=> false,
                    'message'=> 'User already has a role.',
                ], 400);
            }

            $role = auth()->user()->role()->create($validatedData);

            return response()->json([
                'success'=> true,
                'message'=> 'Role created successfully',
                'data'=> $role,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: '. $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validatedData = $request->validate([
            'role_name'=> 'required|string|max:255',
            'description'=> 'required|string|max:255',
        ]);

        $role = Auth::user()->role()->first();

        $message = '';
        if (!$role) {
            $role = Auth::user()->role()->create($validatedData);
            $message = 'Role created successfully';
        } else {
            $role->update($validatedData);
            $message = 'Role updated successfully';
        }

        return response()->json(data: [
            'success'=> true,
            'message'=> $message,
            'data'=> $role,
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        try {
            $role = Auth::user()->role()->first();

            if (!$role) {
                return response()->json([
                    'success'=> false,
                    'message'=> 'User has no role',
                ],404);
            }

            $role->delete();

            return response()->json([
                'success'=> true,
                'message'=> 'Role deleted successfully',
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'success'=> false,
                'message'=> 'An error occurred: '. $th->getMessage(),
            ], 500);
        }
    }
}
