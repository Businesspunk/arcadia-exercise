<?php

namespace Tests\Unit;

use App\Domains\Question\QuestionCreator;
use PHPUnit\Framework\TestCase;

class QuestionCreatorTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_question_list_creation_with_wrong_structure_01()
    {
        $this->expectError();

        QuestionCreator::create([
            ['createdAt' => 1, 'choices' => [
                ['text' => 1],
                ['text' => 1],
                ['text' => 1]
            ]]
        ]);
    }

    public function test_question_list_creation_with_wrong_structure_02()
    {
        $this->expectError();

        QuestionCreator::create([
            ['text' => 1, 'choices' => [
                ['text' => 1],
                ['text' => 1],
                ['text' => 1]
            ]]
        ]);
    }

    public function test_question_list_creation_with_wrong_structure_03()
    {
        $this->expectError();

        QuestionCreator::create([
            ['text' => 1, 'createdAt' => 1]
        ]);
    }

    public function test_question_list_creation_with_acceptable_structure_01()
    {
        QuestionCreator::create([]);
        $this->assertTrue(true);
    }

    public function test_resulted_question_list()
    {
        $questionList = QuestionCreator::create([[
            'text' => 1,
            'createdAt' => 1,
            'choices' => [
                ['text' => 1],
                ['text' => 1],
                ['text' => 1]
            ]]
        ]);

        $this->assertEquals(1, count($questionList->getItems() ));
    }

    public function test_question_creation_with_wrong_param_structure()
    {
        $this->expectError();
        QuestionCreator::createQuestion(1,1, [ [] ]);
    }

    public function test_question_creation_without_choices()
    {
        QuestionCreator::createQuestion(1,1, []);
        $this->assertTrue(true);
    }

    public function test_question_added_choices()
    {
        $question = QuestionCreator::createQuestion(1,1, [ ['text'=>'choice 1'], ['text' => 'choice 2'] ]);
        $this->assertEquals(2, count($question->getChoices()));
    }

    public function test_question_added_choice_value()
    {
        $question = QuestionCreator::createQuestion(1,1, [ ['text'=>'choice 1'], ['text' => 'choice 2'] ]);
        $this->assertEquals('choice 1', $question->getChoices()[0]->getText());
    }
}
