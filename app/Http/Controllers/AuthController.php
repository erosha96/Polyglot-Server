<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\UsersToken;

class AuthController extends Controller
{
    public function register (Request $request) {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|unique:users,phone',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        $user = User::create([
            'name' => 'Student',
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
    }
    public function login (Request $request) {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);
        }
        function loginError () {
            return response()->json([
                'message' => 'Invalid Login And Password',
            ]);
        }
        $user = User::where('phone', $request->phone)->first();
        if ($user && password_verify($request->password, $user->password)) {
            $tokenStr = '';
            do {
                $tokenStr = str_random(60);
            } while (UsersToken::where('token', $tokenStr)->first());
            $token = UsersToken::create([
                'user_id' => $user->id,
                'token' => $tokenStr,
                'active' => true
            ]);
            return response()->json([
                'access_token' => $token->token
            ]);
        } else {
            return loginError();
        }
    }
}
