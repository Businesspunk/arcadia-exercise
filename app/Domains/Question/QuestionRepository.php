<?php


namespace App\Domains\Question;

use App\Domains\Question\DatabaseDrivers\{DatabaseCSV, DatabaseJSON, DatabaseInterface};
use Exception;

class QuestionRepository
{
    protected DatabaseInterface $dbDriver;

    public function __construct($db_type)
    {
        switch ($db_type) {
            case "CSV":
                $this->dbDriver = new DatabaseCSV;
                break;
            case "JSON":
                $this->dbDriver = new DatabaseJSON;
                break;
            default:
                throw new Exception("Undefined question database type");
        }
    }

    public function get()
    {
        return $this->dbDriver->get();
    }

    public function save(array $content)
    {
        $this->dbDriver->save($content);
    }
}
