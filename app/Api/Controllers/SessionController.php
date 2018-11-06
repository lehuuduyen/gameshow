<?php
namespace App\Api\Controllers;

use App\Http\Controllers\BaseController;
use App\Session;

class SessionController extends BaseController {

    public function show($sessionId) {
        $session = Session::whereId($sessionId)
            ->with([
            'questions',
            'questions.answers' => function($q){
                $q->select(['id', 'path', 'url', 'question_id', 'tag'])
                    ->orderBY('tag', 'asc');
            }])
            ->first();

        if(!$session) {
            return response()->json([
                "result" => false,
                "data" => []
            ]);
        }

        $data = [];
        foreach ($session->questions as $keyQ => $question) {
            $data[$keyQ]['id'] = $keyQ+1;
            $data[$keyQ]['question_id'] = $question->id;
            $data[$keyQ]['question'] = $question->content;
            $data[$keyQ]['description'] = $question->description;

            foreach ($question->answers as $keyA => $answer) {

                switch ($answer->tag) {
                    case 0:
                        $data[$keyQ]['files'][$keyA]['title'] = "Intro";
                        break;
                    case 1:
                        $data[$keyQ]['files'][$keyA]['title'] = "Question";
                        break;
                    case 2:
                        $data[$keyQ]['files'][$keyA]['title'] = "Answer";
                        break;
                    case 3:
                        $data[$keyQ]['files'][$keyA]['title'] = "Resolve";
                        break;
                    case 4:
                        $data[$keyQ]['files'][$keyA]['title'] = "Mask";
                        $data[$keyQ]['files'][$keyA]['url'] = URL($answer->url);
                        break;
                }
                $data[$keyQ]['files'][$keyA]['path'] = env('PATH_CONFIG') . $answer->path;
                $data[$keyQ]['files'][$keyA]['tag'] = $answer->tag;
            }
        }

        $res = [
            "result" => true,
            "data" => $data
        ];

        return response()->json($res);
    }

}