<?php


namespace App\Domains\Question;
use App\Domains\Question\DatabaseDrivers\DatabaseCSV;

class QuestionRepository
{
    public $dbDriver = DatabaseCSV::class;

    public function get()
    {
        $driver = new $this->dbDriver;
        return $driver->get();
    }

    public function save(array $content)
    {
        $driver = new $this->dbDriver;
        $driver->save($content);
    }
}
