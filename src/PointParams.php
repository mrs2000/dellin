<?php

declare(strict_types=1);

namespace mrssoft\dellin;

use DateTimeImmutable;

class PointParams implements Arrayable
{
    private string $address;
    private DateTimeImmutable $produceDate;
    private string $worktimeStart = '9:00';
    private string $worktimeEnd = '18:00';

    public function setAddress(string $value): void
    {
        $this->address = $value;
    }

    public function setTime(string $worktimeStart, string $worktimeEnd): void
    {
        $this->worktimeStart = $worktimeStart;
        $this->worktimeEnd = $worktimeEnd;
    }

    public function setDate(DateTimeImmutable $date): void
    {
        $this->produceDate = $date;
    }

    public function toArray(): array
    {
        $result = [
            "variant" => "address",
            'address' => [
                'search' => $this->address
            ],
            'time' => [
                'worktimeStart' => $this->worktimeStart,
                'worktimeEnd' => $this->worktimeEnd,
            ]
        ];
        if (isset($this->produceDate)) {
            $result['produceDate'] = $this->produceDate->format('Y-m-d');
        }

        return $result;
    }
}