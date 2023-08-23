<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\Result;
use App\Models\Test;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Session\Store;

class TestCourseController extends Controller
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
        $test1 = Test::all();
        $user = Auth::user();
        $tests = $test1->where('course_id', $request->input('id'));

        $this->session->put('course_id', $courseId);
        return view('user.tests',compact('tests','peoples'));

    }
    public function show(Request $request){
        $testIds = $request->input('id');
        $userId = Auth::id();
        $result = Result::where('user_id', $userId)
            ->where('test_id', $testIds)
            ->first();
        $test = Test::findOrFail($testIds);

      $test_duration=$test->duration;

        $enteredPassword = $request->input('enteredPassword');

        if ($enteredPassword !== $test->password) {
            return redirect()->back()->withInput()->withErrors(['invalid_password' => 'invalid Password Try Again.']);

            // return redirect('/User_course')->withErrors(['exam_password' => 'Invalid exam password']);
        }

        $questions = DB::table('question_test')
            ->where('test_id', $testIds)
            ->join('questions', 'question_test.question_id', '=', 'questions.id')
            ->get();
        foreach ($questions as $question) {
            $question->options = Question::findOrFail($question->question_id)->options;
        }
        $this->session->put('test_id', $testIds);
        return view('user.question', compact( 'questions','result','test_duration'));
    }


    public function submitAnswers(Request $request)
    {
        $answers = $request->input('answers');

        $score = 0;
        $userId = Auth::id();
        $coId = DB::table('course_user')->where('user_id', $userId)->first();
        $courseId = $coId->course_id;
        //$course_id= $this->session->get('course_id');
        //$test_id=$this->session->get('test_id');
        $test_id = $this->session->get('test_id')[0];


        foreach ($answers as $questionId => $selectedOptions) {
            $correctOptions = QuestionOption::where('question_id', $questionId)
                ->where('correct', 1)
                ->pluck('id')
                ->toArray();
            $selectedOptions = (array) $selectedOptions; // Ensure $selectedOptions is an array

            sort($correctOptions);
            sort($selectedOptions);
            $question = Question::find($questionId);
            if ($correctOptions == $selectedOptions) {
                $score += $question->score;
            }
        }

        $result = new Result();
        $result->user_id = $userId;
        $result->course_id = $courseId;
        $result->test_id = $test_id; // معرف الامتحان
        $result->score = $score;
        $result->submitted = true;
        $result->save();


        return redirect('/User_course');
    }


}

