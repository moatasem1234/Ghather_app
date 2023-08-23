<?php

namespace App\Http\Controllers\Admin;

use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class LessonController extends Controller
{
    public function index(Request $request)
    {


        $lessons = Lesson::whereIn('course_id', Course::pluck('id'));

        if ($request->input('course_id')) {
            $lessons = $lessons->where('course_id', $request->input('course_id'));
        }
        if (request('show_deleted') == 1) {
            if (! Gate::allows('lesson_delete')) {
                return abort(401);
            }
            $lessons = $lessons->onlyTrashed()->get();
        } else {
            $lessons = $lessons->get();
        }

        return view('admin.lessons.index', compact('lessons'));
    }

    public function create()
    {

        $courses = Course::all();

        return view('admin.lessons.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $data = $request->all() + ['position' => Lesson::where('course_id', $request->course_id)->max('position') + 1];
        Lesson::create($data);


       $course = Course::find($request->course_id);
        $message = 'added new lesson to course'.' '.$course->title ;
        foreach ($course->students as $student) {
            $student->notifications()->create([
                'message' => $message,
            ]);
        }
        return redirect()->route('lesson.index',  ['course_id' => $request->course_id]);
    }

    public function show($id)
    {
        //
    }

    public function edit(Lesson $lesson)
    {

        $courses = Course::all();

        return view('admin.lessons.edit', compact('lesson', 'courses'));
    }

    public function update(Request $request,Lesson $lesson)
    {

        $lesson->update($request->all());

        return redirect()->route('lesson.index',  ['course_id' => $request->course_id]);
    }

    public function destroy(Lesson $lesson)
    {
        $lesson->delete();

        return redirect()->route('lesson.index');
    }

    public function restore($id)
    {

        $lesson = Lesson::findOrFail($id);
        $lesson->restore();

        return redirect()->route('course.index');
    }

    public function perma_del($id)
    {
        if (! Gate::allows('course_delete')) {
            return abort(401);
        }
        $lesson = Lesson::onlyTrashed()->findOrFail($id);
        $lesson->forceDelete();

        return redirect()->route('admin.courses.index');
    }
}
