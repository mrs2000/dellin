<?php

declare(strict_types=1);

namespace mrssoft\dellin;

use DateTimeImmutable;

class CalculateRequest implements Arrayable
{
    public const AUTO = 'auto';
    public const EXPRESS = 'express';
    public const AVIA = 'avia';
    public const SMALL = 'small';

    private PointParams $derival;
    private PointParams $arrival;
    private CargoList $cargoList;
    private string $deliveryType;

    public function create(string $deliveryType, DateTimeImmutable $produceDate, PointParams $derival, PointParams $arrival, CargoList $cargoList): void
    {
        $this->derival = $derival;
        $this->arrival = $arrival;
        $this->cargoList = $cargoList;
        $this->deliveryType = $deliveryType;

        $this->derival->setDate($produceDate);
    }

    public function toArray(): array
    {
        return [
            'delivery' => [
                'deliveryType' => [
                    'type' => $this->deliveryType,
                ],
                'derival' => $this->derival->toArray(),
                'arrival' => $this->arrival->toArray(),
            ],
            'cargo' => $this->cargoList->toArray(),
        ];
    }
}
