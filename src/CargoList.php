<?php

declare(strict_types=1);

namespace mrssoft\dellin;

class CargoList implements Arrayable
{
    private const OVAERSIZED_WEIGHT = 100;
    private const OVAERSIZED_SIZE = 3;

    /**
     * @var Cargo[]
     */
    private array $list = [];

    public function add(Cargo $cargo): void
    {
        $this->list[] = $cargo;
    }

    public function toArray(): array
    {
        $length = 0;
        $height = 0;
        $width = 0;

        $weight = 0;
        $totalVolume = 0;
        $totalWeight = 0;
        $oversizedWeight = 0;
        $oversizedVolume = 0;

        foreach ($this->list as $item) {

            if ($length < $item->length) {
                $length = $item->length;
            }
            if ($height < $item->height) {
                $height = $item->height;
            }
            if ($width < $item->width) {
                $width = $item->width;
            }

            if ($weight < $item->weight) {
                $weight = $item->weight;
            }

            $totalWeight += $item->weight;
            $totalVolume += $item->volume;

            if ($weight >= self::OVAERSIZED_WEIGHT || $length >= self::OVAERSIZED_SIZE || $height >= self::OVAERSIZED_SIZE || $width >= self::OVAERSIZED_SIZE) {
                $oversizedWeight += $item->weight;
                $oversizedVolume += $item->volume;
            }
        }

        $result = [
            'length' => $length,
            'height' => $height,
            'width' => $width,
            'weight' => $weight,
            'totalWeight' => $totalWeight,
            'totalVolume' => $totalVolume,
        ];

        if ($oversizedWeight) {
            $result['oversizedWeight'] = $oversizedWeight;
            $result['oversizedVolume'] = $oversizedVolume;
        }

        return $result;
    }
}