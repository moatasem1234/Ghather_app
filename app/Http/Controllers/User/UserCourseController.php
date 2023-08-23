<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserCourseController extends Controller
{

    public function index()
    {


        $peoples = DB::table('users')
            ->inRandomOrder()
            ->paginate(10);

        $user = Auth::user();
        $courses = $user->courses()->get();
        return view('user.course',compact('courses','peoples'));

    }


}
