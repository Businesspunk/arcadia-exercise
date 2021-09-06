<?php

namespace App\Http\Controllers;

use App\Domains\Question\{Choice, Question, QuestionCreator};
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Response, Storage, Validator};

class QuestionController extends Controller
{
    public function getAll(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lang' => 'required|string'
        ]);

        if ($validator->fails()) {
            abort(404);
        }

        $content = json_decode(Storage::get('questions/questions.json'));
        $questionList = QuestionCreator::create($content);

        //$questionList->translate($request->lang);
        return view('questions.all', [
            'questionList' => $questionList,
            'createdAtDefault' => Carbon::now()
        ]);
    }

    public function getAllApi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lang' => 'required|string'
        ]);

        if ($validator->fails()) {
            return Response::json(['code' => 400, 'message' => $validator->errors()->first()], 400);
        }

        $content = json_decode(Storage::get('questions/questions.json'));
        $questionList = QuestionCreator::create($content);
        //$questionList->translate($request->lang);

        return $questionList->toArray();
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required',
            'createdAt' => 'required|date_format:Y-m-d H:i:s',
            'choices' => 'array|size:3'
        ]);

        if ($validator->fails()) {
            abort(404);
        }

        $content = json_decode(Storage::get('questions/questions.json'));
        $questionList = QuestionCreator::create($content);

        $choices = [];
        foreach ($request->choices as $choice) {
            $choices[] = new Choice($choice);
        }
        $question = new Question($request->question, $request->createdAt, $choices);

        $questionList->addItem($question);

        dd($questionList);

        // save questionList

        dd(200);
    }
}
