<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserCourseConcroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function index()
//    {
//        $users = User::all();
//        $courses = Course::all();
//        return view('admin.users.index', compact('courses','users'));
//    }
    public function index()
    {
        $users = User::all();
        $courses = Course::all();
        $errors = session('errors');
        $relationError = $errors ? $errors->first('relation_error') : null;

        return view('admin.users.index', compact('courses', 'users', 'relationError'));
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
//    public function store(Request $request)
//    {
//        $selectedValues = $request->input('checkboxes');
//        foreach ($selectedValues as $selectedValue){
//
//            DB::table('course_user')->insert([
//                'user_id' => $selectedValue, 'course_id'=>$request->course_id
//            ]);
//            return redirect()->route('cu.index');
//        }
//    }
    public function store(Request $request)
    {
        $selectedValues = $request->input('checkboxes');

        $existingRelations = DB::table('course_user')
            ->where('course_id', $request->course_id)
            ->whereIn('user_id', $selectedValues)
            ->get();

        if ($existingRelations->count() > 0) {
            return redirect()->route('cu.index')->withErrors(['relation_error' => 'One or more selected users already have the relation with the course.']);
        }

        foreach ($selectedValues as $selectedValue) {
            DB::table('course_user')->insert([
                'user_id' => $selectedValue,
                'course_id' => $request->course_id
            ]);
        }
        $course = Course::find($request->course_id);

        $message = 'added to course'.' '.$course->title ;
        foreach ($course->students as $student) {
            $student->notifications()->create([
                'message' => $message,

            ]);
        }
        return redirect()->route('cu.index');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('course_user')->where('user_id', $id)->delete();
        return redirect()->route('cu.index');
    }

}
