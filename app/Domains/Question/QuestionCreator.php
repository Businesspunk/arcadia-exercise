<?php


namespace App\Domains\Question;


class QuestionCreator
{
    public static function create(array $content)
    {
        $questions = [];
        foreach ($content as $question) {
            $questions[] = self::createQuestion($question['text'], $question['createdAt'], $question['choices']);
        }

        return new QuestionList($questions);
    }

    public static function createQuestion(string $text, string $createdAt, array $choices)
    {
        $choicesObjects = [];
        foreach ($choices as $choice) {
            $choicesObjects[] = new Choice($choice['text']);
        }

        return new Question($text, $createdAt, $choicesObjects);
    }
}
