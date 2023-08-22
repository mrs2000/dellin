<?php

namespace tests;

class TestBase extends \PHPUnit\Framework\TestCase
{
    protected array $params = [];

    protected \mrssoft\dellin\Dellin $dellin;

    private function loadParams(string $filename): array
    {
        return json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . $filename), true);
    }

    protected function setUp(): void
    {
        $this->params = $this->loadParams('params.json');

        $client = new \GuzzleHttp\Client();
        $this->dellin = new \mrssoft\dellin\Dellin($this->params['appkey'], $client);
    }
}