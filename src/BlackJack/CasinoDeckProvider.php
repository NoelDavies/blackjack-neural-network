<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date: 14/12/16
 * Time: 20:45
 */

namespace BlackJack;

use NoelDavies\Cards\Card;
use NoelDavies\Cards\Contracts\CardProvider;
use NoelDavies\Cards\Suit;

/**
 * The standards cards in a 52 card deck
 */
class CasinoDeckProvider implements CardProvider
{
    /**
     * @var int
     */
    private $decksCount;

    public function __construct($decksCount = 6)
    {
        $this->decksCount = $decksCount;
    }

    /**
     * @return array
     */
    public function getCards()
    {
        $cards = [];

        for($i = 0; $i<$this->decksCount; $i++) {
            $cards = array_merge($this->generateDeck(), $cards);
        }

        return $cards;
    }

    private function addCards(&$cards, $suit)
    {
        $values   = range(2, 10);
        $values[] = Card::ACE;
        $values[] = Card::JACK;
        $values[] = Card::QUEEN;
        $values[] = Card::KING;

        foreach ($values as $v) {

            $cards[] = new Card($v, $suit);
        }
    }

    /**
     * @return array
     */
    private function generateDeck()
    {
        $cards = [];

        $suits = [Suit::club(), Suit::diamond(), Suit::heart(), Suit::spade()];

        foreach ($suits as $suit) {

            $this->addCards($cards, $suit);
        }

        return $cards;
    }
}
