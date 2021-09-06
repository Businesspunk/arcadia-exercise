<?php

namespace App\Domains\Question;

class QuestionList
{
    protected $items;

    public function __construct($items = [])
    {
        $this->items = $items;
    }

    public function addItem($item)
    {
        $this->items[] = $item;
    }

    public function translate($lang)
    {
        foreach ($this->items as $item){
            $item->translate($lang);
        }
    }

    public function toArray()
    {
        $items = [];
        foreach ($this->items as $item){
            $items[] = $item->toArray();
        }
        return $items;
    }

    public function getItems()
    {
        return $this->items;
    }
}
