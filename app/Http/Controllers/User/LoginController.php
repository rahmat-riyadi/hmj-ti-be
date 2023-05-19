<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\API\ResponseController;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login (Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        $user = User::where('username', $request->username)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return ResponseController::create('', 'Unauthorized', "Username atau Password salah", "402");
        }
        $data['access_token'] = $user->createToken('user_token')->plainTextToken;
        $data["user_id"] = $user->id;
        return ResponseController::create($data, 'OK', "Login Success", "200");
    }

    public function logout (Request $request){
        $request->user()->currentAccessToken()->delete();
        return ResponseController::create('', 'OK', "Logout Success", "200");
    }
}
