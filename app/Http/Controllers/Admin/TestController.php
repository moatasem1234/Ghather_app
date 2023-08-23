<?php

namespace App\Http\Controllers\Admin;

use App\Models\Answer;
use App\Models\Result;
use App\Models\Test;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class TestController extends Controller
{
    public function index()
    {

        if (request('show_deleted') == 1) {
            if (! Gate::allows('test_delete')) {
                return abort(401);
            }
            $tests = Test::onlyTrashed()->get();
        } else {
            $tests = Test::all();
        }

        return view('admin.tests.index', compact('tests'));
    }

    public function create()
    {
        $courses = Course::get();
        $courses_ids = $courses->pluck('id');
        $courses = $courses->pluck('title', 'id')->prepend('Please select', '');
        $lessons = Lesson::whereIn('course_id', $courses_ids)->get()->pluck('title', 'id')->prepend('Please select', '');

        return view('admin.tests.create', compact('courses', 'lessons'));
    }

//    public function store(Request $request)
//    {
//        Test::create($request->all());
//        return redirect()->route('tests.index');
//    }
    public function store(Request $request)
    {
        $test = Test::create($request->all());


        $course = Course::find($request->course_id);
        $message = 'اختبار جديد: ' . $test->description;
        foreach ($course->students as $student) {
            $student->notifications()->create([
                'message' => $message,
                'url'=>'/User_course'
            ]);
        }

        return redirect()->route('tests.index');
    }

    public function show($id)
    {

    }

    public function edit(Test $test)
    {

        $courses = Course::all();
        $courses_ids = $courses->pluck('id');
        $courses = $courses->pluck('title', 'id')->prepend('Please select', '');
        $lessons = Lesson::whereIn('course_id', $courses_ids)->get()->pluck('title', 'id')->prepend('Please select', '');

        return view('admin.tests.edit', compact('test', 'courses', 'lessons'));
    }

    public function update(Request $request,Test $test)
    {

        $test->update($request->all());

        return redirect()->route('tests.index');
    }

    public function destroy(Test $test)
    {
        $test->delete();

        return redirect()->route('tests.index');
    }

    public function restore($id)
    {
        $test = Test::findOrFail($id);
        $test->restore();

        return redirect()->route('tests.index');
    }


    public function perma_del($id)
    {

        $test = Test::findOrFail($id);
        $test->forceDelete();

        return redirect()->route('tests.index');
    }



    // Add this method to the TestController class
    // Add this method to the TestController class
    public function viewGrades($id)
    {
        $test = Test::findOrFail($id);
        $grades = Result::where('test_id', $id)
            ->where('submitted', true)
            ->with('user')
            ->get();

        return view('admin.tests.view_grades', compact('test', 'grades'));
    }

//    public function sendGrades($id)
//    {
//        $test = Test::findOrFail($id);
//        $grades = Result::where('test_id', $id)
//            ->where('submitted', true)
//            ->with('user')
//            ->get();
//
//        foreach ($grades as $grade) {
//            $message = 'Your grade for the test "' . $test->title . '" is: ' . $grade->score;
//            $grade->user->notifications()->create([
//                'message' => $message,
//                'url' => '/User_course'
//            ]);
//        }
//
//        return redirect()->route('tests.view_grades', $test->id);
//    }

//?????
    public function sendGrades($id)
    {
        $test = Test::findOrFail($id);
        $grades = Result::where('test_id', $id)
            ->where('submitted', true)
            ->with('user')
            ->get();

        foreach ($grades as $grade) {
            $message = 'Your grade for the test "' . $test->title . '" is: ' . $grade->score;
            $grade->user->notifications()->create([
                'message' => $message,
                'url' => '/User_course'
            ]);

            // Update the Result model to store the grade
            $result = Result::where('user_id', $grade->user_id)
                ->where('test_id', $id)
                ->first();

            if ($result) {
                $result->update(['score' => $grade->score]);
                $result->update(['can_view' => true]);

            }


        }

        return redirect()->route('tests.view_grades', $test->id);
    }

}
