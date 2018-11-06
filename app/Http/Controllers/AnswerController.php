<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use App\Service\UploadService;

class AnswerController extends Controller
{
    public function store(Request $request) {
        if(!($question = Question::find($request->question_id))) {
            return back()
                ->with('error', 'Question không tồn tại');
        }

        if($request->hasFile("tag_0")) {
            $this->addAnswer(0, $request->tag_0, $question);
        }

        if($request->hasFile("tag_1")) {
            $this->addAnswer(1, $request->tag_1, $question);
        }

        if($request->hasFile("tag_2")) {
            $this->addAnswer(2, $request->tag_2, $question);
        }

        if($request->hasFile("tag_3")) {
            $this->addAnswer(3, $request->tag_3, $question);
        }

        if($request->hasFile("tag_4")) {
            $answer = $this->addAnswer(4, $request->tag_4, $question);

            $answer->update([
                "url" => $answer->path
            ]);
        }

        return back()
            ->with('success', 'Thêm mới Answer thành công');
    }

    private function addAnswer($tag, $file, $question) {
        $answer = Answer::whereTag($tag)
                ->whereQuestionId($question->id)
                ->first();
        $filePath = UploadService::handleUploadFile($file);

        if($answer) {
            $answer->update([
                "path" => $filePath
            ]);
        } else {
            $answer = Answer::create([
                "tag" => $tag,
                "path" => $filePath
            ]);

            $answer->question()->associate($question)->save();
        }

        return $answer;
    }
}
