<?php

namespace App\Domains\Question;
use Stichoza\GoogleTranslate\GoogleTranslate;

class Question
{
    protected $text;
    protected $createdAt;
    protected $choices;

    public function __construct($text, $createdAt, $choices = [])
    {
        $this->text = $text;
        $this->createdAt = $createdAt;
        $this->choices = $choices;
    }

    public function translate($lang)
    {
        $gt = new GoogleTranslate($lang);
        $this->text = $gt->translate($this->text);

        foreach ($this->choices as $choice){
            $choice->translate($lang);
        }
    }

    public function toArray()
    {
        $choices = [];
        foreach ( $this->choices as $choice ){
            $choices[] = $choice->toArray();
        }

        return [
            "text" => $this->text,
            "createdAt" => $this->createdAt,
            "choices" => $choices
        ];
    }

    public function getChoices()
    {
        return $this->choices;
    }

    public function getText()
    {
        return $this->text;
    }
}
