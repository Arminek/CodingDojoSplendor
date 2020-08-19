<?php

declare(strict_types=1);

namespace App;

final class Game
{
    /**
     * @var Merchant[]
     */
    private array $merchants;

    private int $tokenPileOnyx = 7;
    private int $tokenPileRuby = 7;
    private int $tokenPileSapphire = 7;
    private int $tokenPileDiamond = 7;
    private int $tokenPileEmerald = 7;
    private int $tokenPileGold = 5;

    public function __construct(Merchant ...$merchants)
    {
        $this->merchants = $merchants;
    }
}