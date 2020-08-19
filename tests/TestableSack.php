<?php

declare(strict_types=1);

namespace Tests;

use App\Sack;

final class TestableSack extends Sack
{
    public function setTokenAmount(string $color, int $amount): void
    {
        $this->gems[$color] = $amount;
    }
}
