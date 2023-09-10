<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\API\ResponseController;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required',
            'password' => 'required|min:8',
        ]);
        if (Auth::attempt($validated)) {
            $user = Auth::user();
            $data = [
                "token" => $user->createToken('token')->plainTextToken,
                "user" => [
                    "username" => $user->username,
                    "email" => $user->email,
                ],
            ];
            return ResponseController::create($data, 'OK', "Login Success", "200");
        } else {
            return ResponseController::create('', 'Unauthorized', "Username atau Password salah", "402");
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return ResponseController::create('', 'OK', "Logout Success", "200");
    }
}
