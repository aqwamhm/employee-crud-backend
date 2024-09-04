<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'status' => 'fail',
                'message' => 'Email atau Password Anda salah'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'user'    => auth()->guard('api')->user(),
            'token'   => $token
        ], 200);
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Logged out successfully']);
    }

    public function verifyToken(Request $request)
    {
        $token = $request->bearerToken();
        try {
            JWTAuth::parseToken()->authenticate();

            return response()->json([
                'status' => 'success',
                'token' => $token,
            ], 200);
        } catch (JWTException $e) {
            if ($e instanceof TokenExpiredException) {
                $newToken = JWTAuth::refresh($token);
                
                return response()->json([
                    'status' => 'success',
                    'token' => $newToken,
                ], 200);
            } else {
                return response()->json([
                    'status' => 'fail',
                    'message' => 'Token Invalid'
                ], 401);
            }
        }
    }
}
