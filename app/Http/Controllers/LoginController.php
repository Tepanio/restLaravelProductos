<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => 'login']);
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['username', 'password']);

        error_log(json_encode($credentials));

        if( ! $token = auth()->attempt($credentials)) {
            return response()->json('', 401);
        }

        return $this->tokenResponse($token);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json('', 200);
    }


    protected function tokenResponse($token)
    {
        return response()->json([
            'token' => $token,
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
