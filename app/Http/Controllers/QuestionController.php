<?php

namespace App\Http\Controllers;

use App\Http\Requests\Question\CUQuestion;
use App\Question;
use App\Session;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class QuestionController extends Controller
{
    public function index() {
        return view('pages.question.index');
    }

    public function datatable(Request $request) {
        $questions = Question::with(['sessions']);

        if($request->has('exclude_questions') && !empty($request->exclude_questions)) {
            $questions = $questions->whereNotIn('id', $request->exclude_questions);
        }

        return DataTables::of($questions)
            ->make(true);
    }

    public function store(CUQuestion $request) {

        Question::create($request->all());

        return back()
            ->with('success', 'Thêm mới session thành công');
    }

    public function update(CUQuestion $request, $questionId) {

        if(!($question = Question::find($questionId))) {
            return back()
                ->with('error', 'Question không tồn tại');
        }

        $question->update($request->all());

        return back()
            ->with('success', 'Cập nhật question thành công');
    }

    public function show($questionId) {
        $question = Question::whereId($questionId)
                ->with('answers')
                ->first();

        return view('pages.question.detail')
                ->with('question', $question);
    }

    public function destroy($questionId) {
        if(!($question = Question::find($questionId))) {
            return response()->json([
                'success' => false,
                'message' => "Question không tồn tại"
            ]);
        }

        $question->sessions()->detach();
        $question->answers()->delete();

        $question->delete();

        return response()->json([
            'success' => true,
            'message' => "Xoá Question thành công"
        ]);
    }

}
