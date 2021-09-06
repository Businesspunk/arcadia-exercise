<?php


namespace App\Domains\Question\DatabaseDrivers;

use Illuminate\Support\Facades\Storage;


class DatabaseJSON implements DatabaseInterface
{
    protected $filePath = "questions/questions.json";

    public function get(): array
    {
        $content = Storage::get($this->filePath);
        return json_decode($content, true);
    }

    public function save(array $content)
    {
        Storage::put($this->filePath, json_encode($content));
    }
}
