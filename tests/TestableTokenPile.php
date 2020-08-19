<?php

declare(strict_types=1);

namespace Tests;

use App\TokenPile;

class TestableTokenPile extends TokenPile
{
    public function setTokenAmount(string $color, int $amount): void
    {
        $this->tokens[$color] = $amount;
    }
}
