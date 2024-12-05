<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\ResponseFormatter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function login(){
        $validator = \Validator::make(request()->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return ResponseFormatter::error(400, $validator->errors());
        }
        $email = request()->email;
        $password = request()->password;

        $user = User::where('email', $email)->first();
        if (!$user) {
            return ResponseFormatter::error(401, ['message' => 'User tidak ditemukan']);
        }

        $userPassword = $user->password;
        if (Hash::check($password, $userPassword)) {
            return ResponseFormatter::success([
                'token' => $user->createToken(config('app.name'))->plainTextToken
            ]);
        }
        return ResponseFormatter::error(401, ['message' => 'Password salah']);
    }
}
