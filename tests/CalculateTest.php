<?php

namespace tests;

use DateTimeImmutable;
use mrssoft\dellin\CalculateRequest;
use mrssoft\dellin\Cargo;
use mrssoft\dellin\CargoList;
use mrssoft\dellin\PointParams;

class CalculateTest extends \tests\TestBase
{
    public function testCalculate()
    {
        $request = new CalculateRequest();
        $date = (new DateTimeImmutable('now'))->modify('-1 day');

        $derival = new PointParams();
        $derival->setAddress('г. Иркутск, ул. Розы Люксембург, 3А');

        $arrival = new PointParams();
        $arrival->setAddress('г. Красноякск, ул. Водопьянова, 16, кв. 21');

        $cargoList = new CargoList();
        $cargoList->add(new Cargo(1, 1, 1, 1, 12));

        $request->create(CalculateRequest::AUTO, $date, $derival, $arrival, $cargoList);

        $reponse = $this->dellin->calculate($request);

        self::assertNotEmpty($reponse->getPrice());
    }
}