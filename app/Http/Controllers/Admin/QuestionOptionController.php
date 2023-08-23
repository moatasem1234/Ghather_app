<?php

namespace App\Http\Controllers\Admin;

use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\QuestionOption;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class QuestionOptionController extends Controller
{

    public function index()
    {
            $question_options = QuestionOption::all();
        return view('admin.question_options.index', compact('question_options'));
    }

    public function create()
    {
        $questions = Question::get()->pluck('question', 'id')->prepend('Please select', '');
        return view('admin.question_options.create', compact('questions'));
    }

    public function store(Request $request)
    {

        QuestionOption::create($request->except('correct') + ['correct' => $request->input('correct') ? 1 : 0]);

        return redirect()->route('question_options.index');
    }

    public function show($id)
    {
        //
    }


    public function edit(QuestionOption $question_option)
    {

        $questions = Question::get()->pluck('question', 'id')->prepend('Please select', '');

        return view('admin.question_options.edit', compact('question_option', 'questions'));
    }


    public function update(Request $request,QuestionOption $question_option)
    {

        $question_option->update($request->except('correct') + ['correct' => $request->input('correct') ? 1 : 0]);

        return redirect()->route('question_options.index');
    }

    public function destroy(QuestionOption $question_option)
    {
        $question_option->delete();

        return redirect()->route('question_options.index');
    }

    public function restore($id)
    {

        $question_option = QuestionOption::onlyTrashed()->findOrFail($id);
        $question_option->restore();

        return redirect()->route('question_options.index','?show_deleted=1');
    }

    public function perma_del($id)
    {

        $question_option = QuestionOption::onlyTrashed()->findOrFail($id);
        $question_option->forceDelete();

        return redirect()->route('question_options.index','?show_deleted=1');
    }
}
