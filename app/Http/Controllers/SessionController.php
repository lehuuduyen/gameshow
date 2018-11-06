<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use App\Http\Requests\Session\CUSession;
use App\Session;
use Yajra\DataTables\DataTables;

class SessionController extends Controller
{
    public function index() {
        return view('pages.session.index');
    }

    public function show($sessionId) {
        $session = Session::find($sessionId);

        return view('pages.session.detail')
                ->with('session', $session);
    }

    public function datatable() {
        return DataTables::of(Session::orderBy('id', 'desc'))
                ->make(true);
    }

    public function store(CUSession $request) {
        Session::create($request->all());

        return back()
            ->with('success', 'Thêm mới session thành công');
    }

    public function update(CUSession $request, $sessionId) {
        if(!($session = Session::find($sessionId))) {
            return back()
                ->with('error', 'Session không tồn tại');
        }

        $session->update($request->all());

        return back()
            ->with('success', 'Cập nhật session thành công');
    }

    public function addQuestion(Request $request, $sessionId) {
        if(!($session = Session::find($sessionId))) {
            return response()->json([
                'success' => false,
                'message' => "Session không tồn tại"
            ]);
        }

        if(!($question = Question::find($request->question_id))) {
            return response()->json([
                'success' => false,
                'message' => "Question không tồn tại"
            ]);
        }

        if($question->sessions()->whereSessionId($session->id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => "Question đã tồn tại trong Session"
            ]);
        }

        $lastOrder = $session->questions()->orderBy('order', 'desc')->first();

        $session->questions()
                ->attach($question, [
                    "order" => $lastOrder ? $lastOrder->pivot->order : 0
                ]);

        return response()->json([
            'success' => true,
            'message' => "Thêm Question thành công"
        ]);
    }

    public function deleteQuestion(Request $request, $sessionId) {
        if(!($session = Session::find($sessionId))) {
            return response()->json([
                'success' => false,
                'message' => "Session không tồn tại"
            ]);
        }

        if(!($question = Question::find($request->question_id))
        || !$question->sessions()->whereSessionId($session->id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => "Question không tồn tại"
            ]);
        }

        $session->questions()
            ->detach($question);

        return response()->json([
            'success' => true,
            'message' => "Xoá Question thành công"
        ]);
    }

    public function listQuestion($sessionId) {
        $session = Session::find($sessionId);

        $questions = $session->questions()
            ->with('sessions')
            ->orderBy('order', 'asc');

        return DataTables::of($questions)
            ->make(true);
    }

    public function updateOrder(Request $request, $sessionId) {
        if(!($session = Session::find($sessionId))) {
            return response()->json([
                'success' => false,
                'message' => "Session không tồn tại"
            ]);
        }

        foreach ($request->order as $order) {
            $session->questions()->updateExistingPivot($order['id'], [
               "order" => $order['position']
            ], false);
        }

        return response("change order success");
    }

}
