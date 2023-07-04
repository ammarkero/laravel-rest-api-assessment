<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Http\Resources\RoleUserCollection;
use App\Http\Resources\RoleUserResource;

class RoleUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
        return response()->json([
            'data' => $user->roles->pluck('title', 'id')
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(User $user, Request $request)
    {
        $validatedData = $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);
        
        if ($user->roles->contains($validatedData['role_id'])) {
            return response()->json([
                'message' => 'The user already has this role.'
            ], 500);
        }

        $user->roles()->attach($validatedData['role_id']);
        
        return response()->json([
            'data' => [
                'user_id' => $user->id,
                'role_id' => $validatedData['role_id'],
            ]
        ], 201);
    }
}
