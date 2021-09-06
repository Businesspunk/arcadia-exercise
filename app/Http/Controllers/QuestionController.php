<?php

namespace App\Http\Controllers;

use App\Domains\Question\{QuestionCreator, QuestionRepository};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Response, Validator};

class QuestionController extends Controller
{
    public function getAll(Request $request)
    {
        $isApi = $request->is('api/*');

        $validator = Validator::make($request->all(), [
            'lang' => 'required|string'
        ]);

        if ($validator->fails()) {
            if ($isApi) {
                return Response::json(['code' => 400, 'message' => $validator->errors()->first()], 400);
            } else {
                abort(404);
            }
        }

        $content = (new QuestionRepository())->get();
        $questionList = QuestionCreator::create($content);

        //$questionList->translate($request->lang);

        if ($isApi) {
            return $questionList->toArray();
        } else {
            return view('questions.all', [
                'questionList' => $questionList,
                'createdAtDefault' => Carbon::now()
            ]);
        }

    }

    public function create(Request $request)
    {
        $isApi = $request->is('api/*');

        $validator = Validator::make($request->all(), [
            'question' => 'required',
            'createdAt' => 'required|date_format:Y-m-d H:i:s',
            'choices' => 'required|array|size:3'
        ]);

        if ($validator->fails()) {
            if($isApi){
                return Response::json(['code' => 400, 'message' => $validator->errors()->first()], 400);
            }else{
                abort(404);
            }
        }

        $questionRepository = new QuestionRepository();
        $content = $questionRepository->get();

        $questionList = QuestionCreator::create($content);

        $question = QuestionCreator::createQuestion(
            $request->question,
            $request->createdAt,
            array_map( function ($item) { return ["text" => $item]; }, $request->choices)
        );

        $questionList->addItem($question);
        $questionRepository->save($questionList->toArray());

        if( $isApi ){
            return $questionList->toArray();
        }else{
            return redirect()->route('questions.all', ['lang' => 'en']);
        }
    }
}
