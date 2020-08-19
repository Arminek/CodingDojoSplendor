<?php

namespace Tests;

use App\Game;
use App\TokenPile;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Webmozart\Assert\Assert;

class GameContext implements Context
{
    /**
     * @var TestableTokenPile
     */
    private $tokenPile;

    /**
     * @var TestableSack[]
     */
    private $merchantSacks = [];

    /**
     * @var string|null
     */
    private $currentMerchantTurn;

    /**
     * @var Game
     */
    private $game;

    /**
     * @var bool
     */
    private $takeFromPileResult = false;

    /**
     * @var bool
     */
    private $resultEndTurn = false;

    /**
     * @Given the game has been set up for :merchants merchants
     */
    public function theGameHasBeenSetUpForMerchants(string $merchants): void
    {
        $this->game = new Game();

        $merchants = explode(', ', $merchants);

        foreach ($merchants as $merchant) {
            $this->merchantSacks[$merchant] = new TestableSack();
        }
        $this->tokenPile = new TestableTokenPile();
    }

    /**
     * @Given the game has been set up for :firstMerchant, :secondMerchant, :thirdMerchant and :fourthMerchant merchants
     */
    public function theGameHasBeenSetUpForAndMerchants($arg1, $arg2, $arg3, $arg4): void
    {
    }

    /**
     * @Given current turn is for the :merchant merchant
     */
    public function currentTurnIsForTheMerchant(string $merchant): void
    {
        $this->currentMerchantTurn = $merchant;
    }

    /**
     * @Given :merchantName has :gemsCount gems in his sack
     */
    public function hasGemsInHisSack(string $merchantName, int $gemsCount): void
    {
        $this->merchantSacks[$merchantName]->setTokenAmount(TokenPile::DIAMOND, $gemsCount);
    }

    /**
     * @When I try to end turn
     */
    public function iTryToEndTurn(): void
    {
        $this->resultEndTurn = $this->game->endTurn();
    }

    /**
     * @When I fail to end turn
     */
    public function iFailToEndTurn(): void
    {
        Assert::false($this->resultEndTurn);
    }

    /**
     * @When I take :gems gem tokens
     */
    public function iTakeOnyxRubySapphireGemTokens(string $gems): void
    {
        $gemColors = explode(', ', $gems);
        if (count($gemColors) === 3) {
            $this->takeFromPileResult = $this->tokenPile->takeThree($gemColors[0], $gemColors[1], $gemColors[2]);
            $this->merchantSacks[$this->currentMerchantTurn]->give($gemColors[0], 1);
            $this->merchantSacks[$this->currentMerchantTurn]->give($gemColors[1], 1);
            $this->merchantSacks[$this->currentMerchantTurn]->give($gemColors[2], 1);
        } else {
            $this->takeFromPileResult = $this->tokenPile->takeTwo($gemColors[0]);
            $this->merchantSacks[$this->currentMerchantTurn]->give($gemColors[0], 1);
            $this->merchantSacks[$this->currentMerchantTurn]->give($gemColors[0], 1);
        }
    }

    /**
     * @When I take diamond, emerald, ruby gem tokens
     */
    public function iTakeDiamondEmeraldRubyGemTokens(): void
    {
        //throw new PendingException();
    }

    /**
     * @Then I should have in my gem sack :gems gem tokens
     */
    public function iShouldHaveInMyGemSackGemTokens(string $gems): void
    {
        $gemColors = explode(', ', $gems);
        $colorCount = array_count_values($gemColors);

        foreach ($gemColors as $gemColor) {
            Assert::eq($colorCount[$gemColor], $this->merchantSacks[$this->currentMerchantTurn]->amountOfTokens($gemColor));
        }
    }

    /**
     * @Then I should have in my gem sack diamond, emerald, ruby gem tokens
     */
    public function iShouldHaveInMyGemSackDiamondEmeraldRubyGemTokens(): void
    {

    }


    /**
     * @Then in token piles should be :numberOfOnyxTokens onyx, :numberOfRubyTokens ruby, :numberOfSapphireTokens sapphire, :numberOfDiamondTokens diamond, :numberOfEmeraldTokens emerald gem tokens and :numberOfGoldTokens gold tokens
     */
    public function inTokenPilesShouldBeOnyxRubySapphireDiamondEmeraldGemTokensAndGoldTokens(
        int $numberOfOnyxTokens,
        int $numberOfRubyTokens,
        int $numberOfSapphireTokens,
        int $numberOfDiamondTokens,
        int $numberOfEmeraldTokens,
        int $numberOfGoldTokens
    ): void
    {
        Assert::eq($this->tokenPile->amountOfTokens(TokenPile::ONYX), $numberOfOnyxTokens);
        Assert::eq($this->tokenPile->amountOfTokens(TokenPile::EMERALD), $numberOfEmeraldTokens);
        Assert::eq($this->tokenPile->amountOfTokens(TokenPile::DIAMOND), $numberOfDiamondTokens);
        Assert::eq($this->tokenPile->amountOfTokens(TokenPile::SAPPHIRE), $numberOfSapphireTokens);
        Assert::eq($this->tokenPile->amountOfTokens(TokenPile::RUBY), $numberOfRubyTokens);
        Assert::eq($this->tokenPile->amountOfTokens(TokenPile::GOLD), $numberOfGoldTokens);
    }

    /**
     * @Then I should not be able to end turn
     */
    public function iShouldNotBeAbleToEndTurn(): void
    {
        Assert::false($this->game->endTurn());
    }

    /**
     * @Then I fail to do that
     */
    public function iFailToDoThat(): void
    {
        Assert::false($this->takeFromPileResult);
    }

    /**
     * @Given current number of tokens in the pile is
     */
    public function currentNumberOfTokensInThePileIs(TableNode $table)
    {
        foreach ($table as $colors) {
            foreach ($colors as $color => $amount) {
                $this->tokenPile->setTokenAmount($color, $amount);
            }
        }
    }
}