<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
class AuthController extends Controller
{

public function register(Request $request)
{
    $fields = $request->validate([
        'name' => 'required|string|max:200',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:4',
    ]);

    $user = User::create([
        'name' => $fields['name'],
        'email' => $fields['email'],
        'password' => Hash::make($fields['password']),
    ]);

    $token = $user->createToken($request->name ?? 'auth_token')->plainTextToken;

    return response()->json([
        'user' => $user
    ], 201);
}

public function login (Request $request){
 $fields = $request->validate([
        'email' => 'required',
        'password' => 'required',
    ]);
    $user = User::where('email', $fields['email'])->first();
    if (! $user || ! Hash::check($fields['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'user' => $user,
        'token' => $token
    ]);
}

public function logout (Request $request){
  $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
}
}
