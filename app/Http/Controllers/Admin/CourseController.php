<?php

namespace App\Http\Controllers\Admin;
use App\Models\CourseUser;
use App\Models\Result;
use Dompdf\Options;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use App\Models\Answer;
use App\Models\Assignments;
use App\Models\User;
use App\Models\Course;
use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreCoursesRequest;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Facades\Excel;


class CourseController extends Controller
{

    public function index()
    {
        $courses = Course::all();
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(StoreCoursesRequest $request)
    {
        $data = $request->all();
        $course = Course::create($data);
        return redirect()->route('courses.index');
    }

    public function show($id)
    {

        $course = Course::findOrFail($id);

        $assignments = $course->assignments;
        $courseId=$course->id;

        $answers = Answer::where('course_id', $courseId)->with('user')->get();
        #$tests = Result::where('course_id', $courseId)->with('test')->get();

        return view('admin.courses.show', compact('course', 'assignments', 'answers'));
    }

    public function show_student($id)
    {

        $course = Course::findOrFail($id);

        $courseId=$course->id;

        $users = CourseUser::where('course_id', $courseId)->with('user')->get();

        return view('admin.courses.details', compact('course','users'));
    }

    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    public function update(StoreCoursesRequest $request, Course $course)
    {
        $data = $request->all();
        $course->update($data);
        return redirect()->route('courses.index');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index');
    }

    public function restore($id)
    {

        $course = Course::findOrFail($id);
        $course->restore();

        return redirect()->route('admin.courses.index');
    }

    public function perma_del($id)
    {
        $course = Course::findOrFail($id);
        $course->forceDelete();
        return redirect()->route('courses.index');
    }


}


