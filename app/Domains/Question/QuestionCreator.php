<?php


namespace App\Domains\Question;


class QuestionCreator
{
    public static function create($content)
    {
        $questions = [];
        foreach ($content as $question){
            $choices = [];
            foreach ($question->choices as $choice){
                $choices[] = new Choice($choice->text);
            }
            $questions[] = new Question($question->text, $question->createdAt, $choices);
        }

        return new QuestionList($questions);
    }
}
