<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Course;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Course as CourseResource;
use App\Word;
use Illuminate\Http\Request;

class CoursesController extends Controller
{
    public function get(Request $request){
        $user = $request->user();
        $course = $user->allCourses()->with(['words.usersResult' => function ($query) use ($user) {
            $query->where('user_id', '=', $user->id)->withPivot('learned_times','last_time_learned');
        }])->get();
        return CourseResource::collection($course);
    }
    public function search(Request $request){
        $user = $request->user();
        $courses = Course::where('created_user_id', '<>', $user->id)->orWhere('created_user_id', null)->with(
            ['usersResult' => function ($query) use ($user) {
                $query->where('user_id', '=', $user->id);
            }]
        )->get();
        return CourseResource::collection($courses);
    }
}
