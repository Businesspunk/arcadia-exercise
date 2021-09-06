<?php


namespace App\Domains\Question\DatabaseDrivers;


interface DatabaseInterface
{
    public function get(): array;

    public function save(array $content);
}
