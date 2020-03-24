<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

class WordsController extends Controller
{
    public function learn(Request $request)
    {
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            "words"    => "required|array|min:0",
            "words.*.id"  => [
                "required",
                "integer",
                "exists:words"
            ],
            "words.*.last_time_learned" => "required|integer"
        ]);
        if ($validator->fails()) {
            return response()->json(['inputError'=>$validator->errors()], 401);
        }
        $ids = new Collection($request->words);
        $ids->each(function ($item, $key) use ($user) {
            $user->learnedWords()->syncWithoutDetaching([
                $item['id'] => [
                    'last_time_learned' => $item['last_time_learned']
                ]
            ]);
        });
    }
}
