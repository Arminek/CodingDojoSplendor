<?php

namespace App;

class Sack
{
    protected $gems = [];

    public function amountOfTokens(string $color): int
    {
        return $this->gems[$color] ?? 0;
    }

    public function give(string $color, int $amount): void
    {
        $this->gems[$color] += $amount;
    }
}