<?php

namespace BlackJack;

use NoelDavies\Cards\Card;

class Hand
{
    /**
     * @var CardCollection
     */
    private $cards;

    /**
     * BlackJack Constructor
     *
     * @param CardCollection $cards
     */
    public function __construct(CardCollection $cards)
    {
        $this->cards = $cards;
    }

    public function handIsGood()
    {
        // Check for 21
        if ($this->handIsBlackJack()) {
            return true;
        }

        return false;
    }

    /**
     * @param CardCollection $cards
     *
     * @return static
     */
    public static function create(CardCollection $cards)
    {
        return new static($cards);
    }

    /**
     * @return CardCollection
     */
    public function cards()
    {
        return $this->cards;
    }

    /**
     * Determines if a hand is blackjack or not
     *
     * @return bool
     */
    public function handIsBlackJack()
    {
        if ($this->cards->count() !== 2) {
            return false;
        }

        $aceExists = $this->cards->filter(function (Card $card){
            return $card->isAce();
        });

        $tenExists = $this->cards->filter(function (Card $card){
            return $this->cardValue($card) === 10;
        });

        if ($aceExists->count() > 0 && $tenExists->count() > 0) {
            return true;
        }

        return false;
    }

    /**
     * @param Card $card
     * @param bool $dropAceToOne
     *
     * @return int
     */
    public function cardValue(Card $card, $dropAceToOne = false)
    {
        if ($card->isAce()) {
            return $dropAceToOne ? 1 : 11;
        }

        return $card->isFaceCard() ? 10 : $card->value();
    }

    /**
     * @return int
     */
    public function handTotal()
    {
        $numberOfAces = $this->cards->filter(function (Card $card){
            return $card->isAce();
        })->count();

        $regularHandCount = $this->cards->sum(function (Card $card) {
            return $this->cardValue($card);
        });

        while ($numberOfAces > 0 && $regularHandCount > 21) {
            $regularHandCount -= 10;
            --$numberOfAces;
        }

        return $regularHandCount;
    }
}
