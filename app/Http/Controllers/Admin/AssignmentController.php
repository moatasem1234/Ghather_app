<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignments;
use App\Models\Course;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{

    public function index()
    {
        $assignments = Assignments::all();

        return view('admin.assignments.index', compact('assignments'));
    }

    public function create()
    {
        $courses = Course::all();

        return view('admin.assignments.create', compact('courses'));
    }

//    public function store(Request $request)
//    {
//        $data = $request->validate([
//            'title' => 'required',
//            'description' => 'required',
//            'course_id' => 'required|exists:courses,id',
//            'deadline' => 'required',
//        ]);
//
//        Assignments::create($data);
//
//        return redirect()->route('admin.assignments.index')->with('success', 'Assignment created successfully.');
//    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'course_id' => 'required|exists:courses,id',
            'deadline' => 'required',
        ]);
        $assignment = Assignments::create($data);

        $course = Course::find($request->course_id);
        $message = 'created new assignment' . $assignment->description;
        foreach ($course->students as $student) {
            $student->notifications()->create([
                'message' => $message,
                'url'=>'/assignments/'.$assignment->id.'/answer'
            ]);
        }
        return redirect()->route('admin.assignments.index')->with('success', 'Assignment created successfully.');
    }

    public function perma_del($id)
    {
        $course = Assignments::findOrFail($id);
        $course->forceDelete();
        return redirect()->route('admin.assignments.index');
    }

}
