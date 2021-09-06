<?php


namespace App\Domains\Question\DatabaseDrivers;

use League\Csv\{Reader, Writer};
use Illuminate\Support\Facades\Storage;

class DatabaseCSV implements DatabaseInterface
{
    protected $filePath = "questions/questions.csv";

    public function get(): array
    {
        $path = Storage::path($this->filePath);
        $csv = Reader::createFromPath($path, 'r');

        $result = [];

        foreach ($csv->getRecords() as $question) {
            static $i = 0;
            if( $i == 0 ){
                $i++;
                continue;
            }

            $data = $question;

            $result[] = [
                "text" => $data[0],
                "createdAt" => $data[1],
                "choices" => [
                    ["text" => $data[2]],
                    ["text" => $data[3]],
                    ["text" => $data[4]],
                ]
            ];
        }

        return $result;
    }

    public function save(array $content)
    {
        $header = ["Question text", "Created At", "Choice 1", "Choice", "Choice 3"];
        $path = Storage::path($this->filePath);
        $writer = Writer::createFromPath($path, 'w+');

        $writer->insertOne($header);

        foreach ($content as $item) {
            $insertableItem = [
                $item['text'],
                $item['createdAt'],
                $item['choices'][0]['text'],
                $item['choices'][1]['text'],
                $item['choices'][2]['text']
            ];

            $writer->insertOne($insertableItem);
        }
    }
}
