<?php

namespace App\Domains\Question;

use Stichoza\GoogleTranslate\GoogleTranslate;

class Choice
{
    protected $text;

    public function __construct($text)
    {
        $this->text = $text;
    }

    public function translate($lang)
    {
        $gt = new GoogleTranslate($lang);
        $this->text = $gt->translate($this->text);
    }

    public function toArray()
    {
        return ["text" => $this->text];
    }

    public function getText()
    {
        return $this->text;
    }
}
