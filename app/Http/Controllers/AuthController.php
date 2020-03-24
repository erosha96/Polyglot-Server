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
            'login' => 'required|unique:users,login',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['inputError'=>$validator->errors()], 401);
        }
        $user = User::insert([
            'name' => 'Student',
            'login' => $request->login,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        if ($user) {
            return response()->json([
                'message' => 'Successfully created user!'
            ], 201);
        } else {
            return response()->json([
                'error' => 'Error creating'
            ], 500);
        }
    }
    public function login (Request $request) {
        $validator = Validator::make($request->all(), [
            'login' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['inputError'=>$validator->errors()], 401);
        }
        function loginError () {
            return response()->json([
                'message' => 'Invalid Login And Password',
            ], 401);
        }
        $user = User::where('login', $request->login)->first();
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
