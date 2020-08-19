<?php

namespace App;

class TokenPile
{
    const ONYX = 'onyx';
    const EMERALD = 'emerald';
    const DIAMOND = 'diamond';
    const SAPPHIRE = 'sapphire';
    const RUBY = 'ruby';
    const GOLD = 'gold';

    /**
     * @var array
     */
    protected $tokens;

    public function __construct()
    {
        $this->tokens = [
            self::ONYX => 7,
            self::EMERALD => 7,
            self::DIAMOND => 7,
            self::SAPPHIRE => 7,
            self::RUBY => 7,
            self::GOLD => 5,
        ];
    }

    public function amountOfTokens(string $color): int
    {
        return $this->tokens[$color] ?? 0;
    }

    public function takeTwo(string $color): bool
    {
        if ($this->tokens[$color] < 2) {
            return false;
        }

        $this->take($color, 2);

        return true;
    }

    public function takeThree(string $fistColor, string $secondColor, string $thirdColor): bool
    {
        if ($this->tokens[$fistColor] < 1) {
            return false;
        }

        if ($this->tokens[$secondColor] < 1) {
            return false;
        }

        if ($this->tokens[$thirdColor] < 1) {
            return false;
        }

        $this->take($fistColor, 1);
        $this->take($secondColor, 1);
        $this->take($thirdColor, 1);

        return true;
    }


    private function take(string $color, int $amount): void
    {
        $this->tokens[$color] -= $amount;
    }
}
