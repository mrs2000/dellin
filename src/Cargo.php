<?php

declare(strict_types=1);

namespace mrssoft\dellin;


class Cargo implements Arrayable
{
    public int $quantity = 1;
    public float $length;
    public float $width;
    public float $height;
    public float $volume;
    public float $weight;

    public function __construct(float $lenght = 0, float $width = 0, float $height = 0, float $volume = 0, float $weight = 0, int $quantity = 1)
    {
        $this->length = $lenght;
        $this->width = $width;
        $this->height = $height;
        $this->volume = $volume;
        $this->weight = $weight;
        $this->quantity = $quantity;
    }

    public function toArray(): array
    {
        return [
            'quantity' => $this->quantity,
            'lenght' => $this->length,
            'width' => $this->width,
            'height' => $this->height,
            'volume' => $this->volume,
            'weight' => $this->weight,
        ];
    }
}