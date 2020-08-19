<?php

declare(strict_types=1);

namespace Tests;

use App\Game;
use App\Merchant;
use Behat\Behat\Context\Context;

final class SelectingTokensContext implements Context
{
    private Game $game;

    /**
     * @Transform :merchant1
     * @Transform :merchant2
     * @Transform :merchant3
     * @Transform :merchant4
     */
    public function castStringToMerchant(string $email): Merchant
    {
        return new Merchant($email);
    }

    /**
     * @Given the game has been set up for :merchant1, :merchant2, :merchant3 and :merchant4 merchants
     */
    public function theGameHasBeenSetUpForAndMerchants(Merchant $merchant1, Merchant $merchant2, Merchant $merchant3, Merchant $merchant4): void
    {
        $this->game = new Game($merchant1, $merchant2, $merchant3, $merchant4);
    }

    /**
     * @Given token piles have been set up for them
     */
    public function tokenPilesHaveBeenSetUpForThem(): void
    {
        // Intentionally left blank - as token piles are set by default for 4 players
    }

    /**
     * @Given current turn is for the :merchant1 merchant
     */
    public function currentTurnIsForTheMerchant(Merchant $merchant1)
    {
        // Intentionally left blank - as for now there's no need to implement the "end turn" functionality
    }
}