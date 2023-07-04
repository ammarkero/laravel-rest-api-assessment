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
        return new RoleUserCollection($user->roles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(User $user, Request $request)
    {
        $validatedData = $request->validate([
            'role_id' => 'required|exists:roles,id',
        ]);

        $user->roles()->attach($validatedData['role_id']);

        return new RoleUserResource($user->roles->last());
    }
}
