<?php

declare(strict_types=1);

namespace mrssoft\dellin;

class CaluculateResponse
{
    private float $price;
    private string $error;

    public function __construct(array $rawResponse)
    {
        if (isset($rawResponse['data']['price'])) {
            $this->price = $rawResponse['data']['price'];
        }
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}