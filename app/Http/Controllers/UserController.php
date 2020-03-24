<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
use Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function getProfile(Request $request){
        return new UserResource($request->user());
    }

    public function checkToken(){
        return response()->json([
            'status' => true
        ], 200);
    }

    public function setProfile(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => [
                'required',
                'email',
                'max:120',
                Rule::unique('users', 'email')->ignore($request->user()),
            ],
            'phone' => [
                'required',
                'max:120',
                Rule::unique('users', 'phone')->ignore($request->user()),
            ]
        ]);
        if ($validator->fails()) {
            return response()->json(['inputError'=>$validator->errors()], 401);
        }
        $user = $request->user();
        if ($request->password) {
            $validator = Validator::make($request->all(), [
                'password' => []
            ]);
            if ($validator->fails()) {
                return response()->json(['inputError'=>$validator->errors()], 401);
            }
            $user->password = bcrypt($request->password);
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();
    }

    public function setAvatar(Request $request) {
        $img = Image::make($request->image)->fit(200);
        $filename = 'aga.jpg';
        while (true) {
            $filename = md5(uniqid('aga', true) . microtime()) . '.jpg';
            if (!Storage::disk('public')->exists('avatars/'.$filename)) break;
        }
        Storage::disk('public')->put('avatars/'.$filename, $img->encode());
        $user = $request->user();
        $user->avatar_url = Storage::url('avatars/'.$filename);
        $user->save();
        return response()->json([
            'avatar_url' => Storage::url('avatars/'.$filename)
        ], 201);
    }
}
