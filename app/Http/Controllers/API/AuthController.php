<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLog;


class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $dataSet = [
            'user_id' => Auth::user()->id,
            'login_timestamp' => now(),
            'token' => $token
        ];
        
        UserLog::create($dataSet);

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        $token = request()->bearerToken();

        $dataSet = [
            'logout_timestamp' => now()
        ];
        
        UserLog::query()
            ->where('user_id', Auth::user()->id)
            ->where('token', $token)
            ->update($dataSet);
        
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
