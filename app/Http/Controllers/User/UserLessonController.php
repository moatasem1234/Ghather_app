<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\TestResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserLessonController extends Controller
{

    public function index(Request $request)
    {
        $peoples = DB::table('users')
            ->inRandomOrder()
            ->paginate(10);
        $lessons1 = Lesson::all();
        $user = Auth::user();
        $lessons = $lessons1->where('course_id', $request->input('id'));
        return view('user.lessons',compact('lessons','peoples'));

    }
    public function test($lesson_slug, Request $request)
    {
        $lesson = Lesson::where('id', $lesson_slug)->firstOrFail();
        $answers = [];
        $test_score = 0;
        foreach ($request->get('questions') as $question_id => $answer_id) {
            $question = Question::find($question_id);
            $correct = QuestionOption::where('question_id', $question_id)
                    ->where('id', $answer_id)
                    ->where('correct', 1)->count() > 0;
            $answers[] = [
                'question_id' => $question_id,
                'question_option_id' => $answer_id,
                'correct' => $correct
            ];
            if ($correct) {
                $test_score += $question->score;
            }
            /*
             * Save the answer
             * Check if it is correct and then add points
             * Save all test result and show the points
             */
        }
        $test_result = TestResult::create([
            'test_id' => $lesson->test->id,
            'user_id' => auth()->id(),
            'test_result' => $test_score
        ]);
        $test_result->answers()->createMany($answers);

        return redirect()->route('lessons.show', [$lesson->course_id, $lesson_slug])->with('message', 'Test score: ' . $test_score);
    }


}
