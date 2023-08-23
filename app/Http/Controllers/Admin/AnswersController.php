<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Assignments;
use App\Models\Course;
use Illuminate\Http\Request;
use Carbon\Carbon;
class AnswersController extends Controller
{
    public function index()
    {
        $courses = Course::all();

        return view('admin.answers.courses', compact('courses'));
    }

    public function showAssignments($courseId)
    {
        $course = Course::findOrFail($courseId);
        $assignments = Assignments::where('course_id', $courseId)->get();

        return view('admin.answers.assignments', compact('course', 'assignments'));
    }

//    public function showAnswers($assignmentId)
//    {
//        $assignment = Assignments::findOrFail($assignmentId);
//        $answers = Answer::where('assignment_id', $assignmentId)->get();
//
//        return view('admin.answers.answers', compact('assignment', 'answers'));
//    }



    public function showAnswers($assignmentId)
    {
        $assignment = Assignments::findOrFail($assignmentId);
        $answers = Answer::where('assignment_id', $assignmentId)->get();

        $delay = null;

        foreach ($answers as $answer) {
            $submittedAt = $answer->created_at;
            $deadline = $assignment->deadline;

            $isLate = $submittedAt->gt($deadline); // التحقق مما إذا كانت التقديم متأخرًا أم لا

            if ($isLate) {
                $delay = $submittedAt->diffForHumans($deadline, true); // حساب التأخير الزمني
            } else {
                $delay = null; // لا يوجد تأخير
            }

            $answer->isLate = $isLate;
            $answer->delay = $delay;
        }

        return view('admin.answers.answers', compact('assignment', 'answers', 'delay'));
    }




//    public function update(Request $request, $assignmentId)
//    {
//        $request->validate([
//            'grades' => 'required|array',
//            'grades.*' => 'numeric|nullable',
//        ]);
//
//        $answers = Answer::where('assignment_id', $assignmentId)->get();
//
//        foreach ($answers as $answer) {
//            $answerId = $answer->id;
//            $newGrade = $request->input('grades.' . $answerId);
//
//            $answer->update([
//                'grade' => $newGrade,
//            ]);
//        }
//
//        return redirect()->back()->with('success', 'تم تحديث الدرجات بنجاح.');
//    }

//    public function update(Request $request, $assignmentId)
//    {
//        $request->validate([
//            'grades' => 'required|array',
//            'grades.*' => 'numeric|nullable',
//        ]);
//
//        $answers = Answer::where('assignment_id', $assignmentId)->get();
//
//        foreach ($answers as $answer) {
//            $answerId = $answer->id;
//            $newGrade = $request->input('grades.' . $answerId);
//
//            $answer->update([
//                'grade' => $newGrade,
//            ]);
//
//            $assignmentName = $answer->assignment->title;
//            $user = $answer->user;
//            $message =  $assignmentName.' '.' درجتك في الوظيفة: ' . $newGrade;
//            $user->notifications()->create([
//                'message' => $message
//            ]);
//        }
//
//        return redirect()->back()->with('success', 'تم تحديث الدرجات بنجاح.');
//    }



    public function update(Request $request, $assignmentId)
    {
        $request->validate([
            'grades' => 'required|array',
            'grades.*' => 'numeric|nullable',
        ]);

        $answers = Answer::where('assignment_id', $assignmentId)->get();

        foreach ($answers as $answer) {
            $answerId = $answer->id;
            $newGrade = $request->input('grades.' . $answerId);

            $answer->update([
                'grade' => $newGrade,
            ]);

            $assignmentName = $answer->assignment->title;
            $user = $answer->user;

            $submittedAt = $answer->created_at; // تاريخ ووقت تقديم الوظيفة
            $deadline = $answer->assignment->deadline; // الموعد النهائي لتقديم الوظيفة
            $delay = $submittedAt->diffForHumans($deadline, false, true);


            $message =  $assignmentName.' '.' your grade: ' . $newGrade.' ';
            $message .=  'submitted'.' '.$delay;


            $user->notifications()->create([
                'message' => $message,
                'url'=>'/assignments/'.$answer->assignment_id.'/answer'
            ]);
        }

        return redirect()->back()->with('success', 'تم تحديث الدرجات بنجاح.')->with('delay', $delay);
    }


}

