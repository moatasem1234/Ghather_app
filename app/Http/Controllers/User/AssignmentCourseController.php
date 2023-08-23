<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Assignments;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\DB;

class AssignmentCourseController extends Controller
{
    protected $session;

    public function __construct(Store $session)
    {
        $this->session = $session;
    }


    public function index(Request $request)
    {
        $peoples = DB::table('users')
            ->inRandomOrder()
            ->paginate(10);

        $courseId = $request->input('id');
        $user = Auth::user();
        $assignments = Assignments::where('course_id', $courseId) ->orderBy('created_at', 'DESC')
            ->get();
        $this->session->put('course_id', $courseId);

        return view('user.assignments', compact('assignments', 'peoples'));
    }

    public function answer($id)
    {
        $peoples = DB::table('users')
            ->inRandomOrder()
            ->paginate(10);
        $assignment = Assignments::findOrFail($id);
        $userId = Auth::id();

       $courseId = $this->session->get('course_id');
        $existingAnswer = Answer::where('user_id', $userId)
            ->where('assignment_id', $assignment->id)
            ->where('course_id', $courseId)
            ->first();
        return view('user.answer', compact('assignment','peoples','existingAnswer'));
    }

    public function submitAnswers(Request $request)
    {
        $assignmentId = $request->input('assignment_id');
        $answerValue = $request->input('answer');

        $userId = Auth::id();

        $courseId = $this->session->get('course_id');
       // dd($courseId);
        $assignment = Assignments::findOrFail($assignmentId);

        // التحقق من وقت انتهاء تقديم الوظيفة

        $existingAnswer = Answer::where('user_id', $userId)
            ->where('assignment_id', $assignmentId)
            ->where('course_id', $courseId)
            ->first();

        if ($existingAnswer) {
            return redirect()->back()->withInput()->withErrors(['submission_error' => 'You have already submitted an answer for this assignment.']);
        }

        $answer = new Answer();
        $answer->user_id = $userId;
        $answer->assignment_id = $assignmentId;
        $answer->course_id = $courseId;
        $answer->answer = $answerValue;

        $answer->save();

        if (Carbon::now()->gt($assignment->deadline)) {
            $submissionError = sprintf('Assignment submission has ended. The deadline was %s.', $assignment->deadline);
            return redirect()->back()->withInput()->withErrors(['submission_error' => $submissionError]);
        }

        return redirect( )->back()->withInput()->withErrors(['submission_success' => 'Assignment submission succeed.']);
    }

}
