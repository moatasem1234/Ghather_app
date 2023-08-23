<?php

namespace App\Http\Controllers\Admin;

use App\Models\Test;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\QuestionOption;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class QuestionController extends Controller
{
    public function index()
    {
        if (request('show_deleted') == 1) {
            if (! Gate::allows('question_delete')) {
                return abort(401);
            }
            $questions = Question::onlyTrashed()->get();
        } else {
            $questions = Question::all();
        }
        $tests = Test::get()->pluck('title', 'id');

        return view('admin.questions.index', compact('questions','tests'));
    }
    public function create()
    {

        $tests = Test::get()->pluck('title', 'id');

        return view('admin.questions.create', compact('tests'));
    }

    public function store(Request $request)
    {

        $data = $request->only('question','question_image','score');

        if ($request->hasFile('question_image')) {
            $image = $request->file('question_image');
            $imageName = time() . '_' . $image->getClientOriginalName(); // ????? ??? ???? ??????
            $destinationPath = public_path('images/questions'); // ?????? ???? ???? ??? ?????? ???
            $image->move($destinationPath, $imageName); // ??? ?????? ?? ?????? ??????
            $data['question_image'] = 'images/questions/' . $imageName; // ????? ?????? ?? ????? ????????
        }



        $question = Question::create($data);
        $question->tests()->sync(array_filter((array)$request->input('test')));
        for ($q=1; $q <= 4; $q++) {
            $option = $request->input('option_text_' . $q, '');
            if ($option != '') {
                QuestionOption::create([
                    'question_id' => $question->id,
                    'option_text' => $option,
                    'correct' => $request->input('correct_' . $q) ? 1 : 0,
                ]);
            }
        }

        return redirect()->route('questions.index');
    }

    public function show($id)
    {
        //
    }

    public function edit(Question $question)
    {

        $tests = Test::get()->pluck('title', 'id');

        return view('admin.questions.edit', compact('question', 'tests'));
    }

    public function update(Request $request,Question $question)
    {


        $data = $request->only('question','question_image','score');

        if ($request->hasFile('question_image')) {
            $image = $request->file('question_image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $destinationPath = public_path('images/questions');
            $image->move($destinationPath, $imageName);
            $data['question_image'] = 'images/questions/' . $imageName;
        }
        $question->update($data);

        return redirect()->route('questions.index');
    }


    public function destroy(Question $question)
    {

        $question->delete();

        return redirect()->route('questions.index');
    }

    public function restore($id)
    {

        $question = Question::onlyTrashed()->findOrFail($id);
        $question->restore();

        return redirect()->route('questions.index');
    }

    public function perma_del($id)
    {

        $question = Question::onlyTrashed()->findOrFail($id);
        $question->forceDelete();

        return redirect()->route('questions.index');
    }


    public function processUploadedExcel(Request $request)
    {
        $uploadedFile = $request->file('excel_file');

        if ($uploadedFile) {
            $filePath = $uploadedFile->store('public/excel_files'); // Upload the file to the temporary path

            $spreadsheet = IOFactory::load(storage_path('app/public/' . $filePath));
            $worksheet = $spreadsheet->getActiveSheet();

            $dataRows = []; // Store all rows and data
            foreach ($worksheet->getRowIterator() as $row) {
                $rowData = [];
                foreach ($row->getCellIterator() as $cell) {
                    $rowData[] = $cell->getValue();
                }
                $dataRows[] = $rowData;
            }

            shuffle($dataRows); // Shuffle the rows randomly

            $selectedQuestionCount = $request->input('random'); // Change this to the desired number of questions

            $selectedDataRows = array_slice($dataRows, 0, $selectedQuestionCount); // Select a subset of rows

            foreach ($selectedDataRows as $rowData) {
                $correctOptionColumn = $rowData[5]; // Get the correct option column from column 5

                $question = Question::create([
                    'question' => $rowData[0],
                    'score' => $rowData[6], // Change the index according to the Score column
                ]);

                $test = $request->input('test');

                for ($i = 1; $i <= 4; $i++) {
                    $optionText = $rowData[$i];
                    $correctOption = ($i == $correctOptionColumn); // Check if the current option is the correct one
                    $option = QuestionOption::create([
                        'question_id' => $question->id,
                        'option_text' => $optionText,
                        'correct' => $correctOption,
                    ]);
                }
                $question->tests()->attach($test);
            }
        }
        return redirect()->route('questions.index');
    }

}
