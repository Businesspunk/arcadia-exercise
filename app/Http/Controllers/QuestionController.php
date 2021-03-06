<?php

namespace App\Http\Controllers;

use App\Domains\Question\{QuestionCreator, QuestionRepository};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Response, Validator};

class QuestionController extends Controller
{
    protected $questionRepository;

    public function __construct( QuestionRepository $questionRepository )
    {
        $this->questionRepository = $questionRepository;
    }

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

        $content = $this->questionRepository->get();
        $questionList = QuestionCreator::create($content);

        try {
            //$questionList->translate($request->lang);
        } catch (\Exception $e) {
            if( $isApi ){
                return Response::json(['code' => 500, 'message' => 'Translate error'], 500);
            }else{
                abort(500);
            }
        }

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

        $content = $this->questionRepository->get();
        $questionList = QuestionCreator::create($content);

        $question = QuestionCreator::createQuestion(
            $request->question,
            $request->createdAt,
            array_map( function ($item) { return ["text" => $item]; }, $request->choices)
        );

        $questionList->addItem($question);
        $this->questionRepository->save($questionList->toArray());

        if( $isApi ){
            return last($questionList->toArray());
        }else{
            return redirect()->route('questions.all', ['lang' => 'en']);
        }
    }
}
