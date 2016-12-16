<?php

namespace spec\BlackJack;

use BlackJack\CardCollection;
use BlackJack\Hand;
use NoelDavies\Cards\Card;
use NoelDavies\Cards\Suit;
use Illuminate\Support\Collection;
use PhpSpec\ObjectBehavior;

class StrategySpec extends ObjectBehavior
{
    public function it_should_stand_when_my_value_is_between_17_and_20()
    {
        $dealersHand = Hand::create(CardCollection::make([
            new Card(7, Suit::club()),
        ]));

        for ($i = 0; $i <= 3; $i++) {
            $myHand = Hand::create(CardCollection::make([
                new Card((7 + $i), Suit::club()),
                new Card(10, Suit::diamond()),
            ]));

            $this->iShouldStand($myHand, $dealersHand)->shouldReturn(true);
            $this->iShouldHit($myHand, $dealersHand)->shouldReturn(false);
            $this->iShouldSurrender($myHand, $dealersHand)->shouldReturn(false);
            $this->iShouldDouble($myHand, $dealersHand)->shouldReturn(false);
        }
    }

    public function it_should_stand_when_my_cards_total_16_and_the_dealer_has_anything_up_to_6()
    {
        $myHand = Hand::create(CardCollection::make([
            new Card(6, Suit::club()),
            new Card(10, Suit::diamond()),
        ]));

        for ($i = 0; $i < 5; $i++) {
            $dealersHand = Hand::create(CardCollection::make([
                new Card((2 + $i), Suit::club()),
            ]));

            $this->iShouldStand($myHand, $dealersHand)->shouldReturn(true);
            $this->iShouldHit($myHand, $dealersHand)->shouldReturn(false);
            $this->iShouldSurrender($myHand, $dealersHand)->shouldReturn(false);
            $this->iShouldDouble($myHand, $dealersHand)->shouldReturn(false);
        }
    }

    public function it_should_hit_when_my_cards_total_16_and_the_dealer_has_a_7_or_8()
    {
        $myHand = Hand::create(CardCollection::make([
            new Card(6, Suit::club()),
            new Card(10, Suit::diamond()),
        ]));

        for ($i = 0; $i < 2; $i++) {
            $dealersHand = Hand::create(CardCollection::make([
                new Card((7 + $i), Suit::club()),
            ]));

            $this->iShouldHit($myHand, $dealersHand)->shouldReturn(true);
            $this->iShouldStand($myHand, $dealersHand)->shouldReturn(false);
            $this->iShouldSurrender($myHand, $dealersHand)->shouldReturn(false);
            $this->iShouldDouble($myHand, $dealersHand)->shouldReturn(false);
        }
    }

    public function it_should_surrender_when_my_cards_total_16_and_the_dealer_has_a_9_10_or_ace()
    {
        $myHand = Hand::create(CardCollection::make([
            new Card(6, Suit::club()),
            new Card(10, Suit::diamond()),
        ]));

        $dealersHand = Hand::create(CardCollection::make([
            new Card(9, Suit::club()),
        ]));
        $this->iShouldSurrender($myHand, $dealersHand)->shouldReturn(true);
        $this->iShouldHit($myHand, $dealersHand)->shouldReturn(false);
        $this->iShouldStand($myHand, $dealersHand)->shouldReturn(false);
        $this->iShouldDouble($myHand, $dealersHand)->shouldReturn(false);

        $dealersHand = Hand::create(CardCollection::make([
            new Card(10, Suit::club()),
        ]));
        $this->iShouldSurrender($myHand, $dealersHand)->shouldReturn(true);
        $this->iShouldHit($myHand, $dealersHand)->shouldReturn(false);
        $this->iShouldStand($myHand, $dealersHand)->shouldReturn(false);
        $this->iShouldDouble($myHand, $dealersHand)->shouldReturn(false);

        $dealersHand = Hand::create(CardCollection::make([
            new Card(Card::ACE, Suit::club()),
        ]));
        $this->iShouldSurrender($myHand, $dealersHand)->shouldReturn(true);
        $this->iShouldHit($myHand, $dealersHand)->shouldReturn(false);
        $this->iShouldStand($myHand, $dealersHand)->shouldReturn(false);
        $this->iShouldDouble($myHand, $dealersHand)->shouldReturn(false);
    }

    public function it_should_stand_when_my_cards_total_15_and_the_dealer_has_between_2_and_6()
    {
        $myHand = Hand::create(CardCollection::make([
            new Card(5, Suit::club()),
            new Card(10, Suit::diamond()),
        ]));

        for ($i = 0; $i < 5; $i++) {
            $dealersHand = Hand::create(CardCollection::make([
                new Card((2 + $i), Suit::club()),
            ]));

            $this->iShouldStand($myHand, $dealersHand)->shouldReturn(true);
            $this->iShouldHit($myHand, $dealersHand)->shouldReturn(false);
            $this->iShouldSurrender($myHand, $dealersHand)->shouldReturn(false);
            $this->iShouldDouble($myHand, $dealersHand)->shouldReturn(false);
        }
    }

    public function it_should_hit_when_my_cards_total_is_15_and_the_dealer_has_7_8_or_9()
    {
        $myHand = Hand::create(CardCollection::make([
            new Card(5, Suit::club()),
            new Card(10, Suit::diamond()),
        ]));

        for ($i = 0; $i < 3; $i++) {
            $dealersHand = Hand::create(CardCollection::make([
                new Card((7 + $i), Suit::club()),
            ]));

            $this->iShouldHit($myHand, $dealersHand)->shouldReturn(true);
            $this->iShouldStand($myHand, $dealersHand)->shouldReturn(false);
            $this->iShouldSurrender($myHand, $dealersHand)->shouldReturn(false);
            $this->iShouldDouble($myHand, $dealersHand)->shouldReturn(false);
        }
    }

    public function it_should_surrender_when_my_cards_total_is_15_and_the_dealer_has_a_10()
    {
        $myHand = Hand::create(CardCollection::make([
            new Card(5, Suit::club()),
            new Card(10, Suit::diamond()),
        ]));

        $dealersHand = Hand::create(CardCollection::make([
            new Card(10, Suit::club()),
        ]));

        $this->iShouldSurrender($myHand, $dealersHand)->shouldReturn(true);
        $this->iShouldStand($myHand, $dealersHand)->shouldReturn(false);
        $this->iShouldHit($myHand, $dealersHand)->shouldReturn(false);
        $this->iShouldDouble($myHand, $dealersHand)->shouldReturn(false);
    }

    public function it_should_hit_when_my_cards_total_is_15_and_the_dealer_has_an_ace()
    {
        $myHand = Hand::create(CardCollection::make([
            new Card(5, Suit::club()),
            new Card(10, Suit::diamond()),
        ]));

        $dealersHand = Hand::create(CardCollection::make([
            new Card(Card::ACE, Suit::club()),
        ]));

        $this->iShouldHit($myHand, $dealersHand)->shouldReturn(true);
        $this->iShouldStand($myHand, $dealersHand)->shouldReturn(false);
        $this->iShouldSurrender($myHand, $dealersHand)->shouldReturn(false);
        $this->iShouldDouble($myHand, $dealersHand)->shouldReturn(false);
    }

    public function it_should_stand_when_my_cards_total_is_13_or_14_and_the_dealer_has_up_to_a_6()
    {
        // 2,3,4,5,6
        for ($dealerIncrement = 2; $dealerIncrement <= 6; $dealerIncrement++) {
            // 6 + 7
            for ($playerIncrement = 6; $playerIncrement <= 7; $playerIncrement++) {
                $myHand = Hand::create(CardCollection::make([
                    new Card($playerIncrement, Suit::club()),
                    new Card(7, Suit::diamond()),
                ]));

                $dealersHand = Hand::create(CardCollection::make([
                    new Card($dealerIncrement, Suit::club()),
                ]));

                $this->iShouldStand($myHand, $dealersHand)->shouldReturn(true);
                $this->iShouldSurrender($myHand, $dealersHand)->shouldReturn(false);
                $this->iShouldHit($myHand, $dealersHand)->shouldReturn(false);
                $this->iShouldDouble($myHand, $dealersHand)->shouldReturn(false);
            }
        }
    }

    public function it_should_hit_when_my_cards_total_is_13_or_14_and_the_dealer_has_between_7_and_ace()
    {
        $dealerCards = CardCollection::make([
            new Card(7, Suit::club()),
            new Card(8, Suit::club()),
            new Card(9, Suit::club()),
            new Card(10, Suit::club()),
            new Card(Card::JACK, Suit::club()),
            new Card(Card::QUEEN, Suit::club()),
            new Card(Card::KING, Suit::club()),
        ]);

        $dealerCards->each(function (Card $dealersCard) {
            $myHand = Hand::create(CardCollection::make([
                new Card(6, Suit::diamond()),
                new Card(7, Suit::diamond()),
            ]));

            $dealersHand = Hand::create(CardCollection::make([
                $dealersCard,
            ]));

            $this->iShouldHit($myHand, $dealersHand)->shouldReturn(true);
            $this->iShouldSurrender($myHand, $dealersHand)->shouldReturn(false);
            $this->iShouldStand($myHand, $dealersHand)->shouldReturn(false);
            $this->iShouldDouble($myHand, $dealersHand)->shouldReturn(false);
        });

        $dealerCards->each(function (Card $dealersCard) {
            $myHand = Hand::create(CardCollection::make([
                new Card(7, Suit::diamond()),
                new Card(7, Suit::diamond()),
            ]));

            $dealersHand = Hand::create(CardCollection::make([
                $dealersCard,
            ]));

            $this->iShouldHit($myHand, $dealersHand)->shouldReturn(true);
            $this->iShouldSurrender($myHand, $dealersHand)->shouldReturn(false);
            $this->iShouldStand($myHand, $dealersHand)->shouldReturn(false);
            $this->iShouldDouble($myHand, $dealersHand)->shouldReturn(false);
        });
    }

    public function it_should_hit_when_my_cards_total_12_and_the_dealers_card_is_2_or_3()
    {
        $myHand = Hand::create(CardCollection::make([
            new Card(10, Suit::club()),
            new Card(2, Suit::diamond()),
        ]));

        for ($i = 2; $i <= 3; $i++) {
            $dealersHand = Hand::create(CardCollection::make([
                new Card($i, Suit::club()),
            ]));

            $this->iShouldHit($myHand, $dealersHand)->shouldReturn(true);
            $this->iShouldSurrender($myHand, $dealersHand)->shouldReturn(false);
            $this->iShouldStand($myHand, $dealersHand)->shouldReturn(false);
            $this->iShouldDouble($myHand, $dealersHand)->shouldReturn(false);
        }
    }

    public function it_should_stand_when_my_cards_total_12_and_the_dealers_card_is_4_5_or_6()
    {
        $myHand = Hand::create(CardCollection::make([
            new Card(10, Suit::club()),
            new Card(2, Suit::diamond()),
        ]));

        for ($i = 4; $i <= 6; $i++) {
            $dealersHand = Hand::create(CardCollection::make([
                new Card($i, Suit::club()),
            ]));

            $this->iShouldStand($myHand, $dealersHand)->shouldReturn(true);
            $this->iShouldHit($myHand, $dealersHand)->shouldReturn(false);
            $this->iShouldSurrender($myHand, $dealersHand)->shouldReturn(false);
            $this->iShouldDouble($myHand, $dealersHand)->shouldReturn(false);
        }
    }

    // Double / hit
    public function it_should_double_when_my_cards_total_11_and_the_dealers_card_is_2_through_10()
    {
        $myHand = Hand::create(CardCollection::make([
            new Card(5, Suit::club()),
            new Card(6, Suit::diamond()),
        ]));

        for ($i = 2; $i <= 10; $i++) {
            $dealersHand = Hand::create(CardCollection::make([
                new Card($i, Suit::club()),
            ]));

            $this->iShouldDouble($myHand, $dealersHand)->shouldReturn(true);
            $this->iShouldHit($myHand, $dealersHand)->shouldReturn(true);
            $this->iShouldSurrender($myHand, $dealersHand)->shouldReturn(false);
            $this->iShouldStand($myHand, $dealersHand)->shouldReturn(false);
        }
    }

    public function it_should_hit_when_my_cards_total_11_and_the_dealers_card_is_an_ace()
    {
        $myHand = Hand::create(CardCollection::make([
            new Card(5, Suit::club()),
            new Card(6, Suit::diamond()),
        ]));

        $dealersHand = Hand::create(CardCollection::make([
            new Card(Card::ACE, Suit::club()),
        ]));

        $this->iShouldHit($myHand, $dealersHand)->shouldReturn(true);
        $this->iShouldDouble($myHand, $dealersHand)->shouldReturn(false);
        $this->iShouldSurrender($myHand, $dealersHand)->shouldReturn(false);
        $this->iShouldStand($myHand, $dealersHand)->shouldReturn(false);
    }

    // Double / hit
    public function it_should_double_when_my_cards_total_10_and_the_dealers_card_is_between_2_and_9()
    {
        $myHand = Hand::create(CardCollection::make([
            new Card(5, Suit::club()),
            new Card(5, Suit::diamond()),
        ]));

        for ($i = 2; $i <= 9; $i++) {
            $dealersHand = Hand::create(CardCollection::make([
                new Card($i, Suit::club()),
            ]));

            $this->iShouldDouble($myHand, $dealersHand)->shouldReturn(true);
            $this->iShouldHit($myHand, $dealersHand)->shouldReturn(true);
            $this->iShouldSurrender($myHand, $dealersHand)->shouldReturn(false);
            $this->iShouldStand($myHand, $dealersHand)->shouldReturn(false);
        }
    }

    public function it_should_hit_when_my_cards_total_10_and_the_dealers_card_is_an_ace_or_10()
    {
        $myHand = Hand::create(CardCollection::make([
            new Card(5, Suit::club()),
            new Card(5, Suit::diamond()),
        ]));

        $dealersHand = Hand::create(CardCollection::make([
            new Card(Card::ACE, Suit::club()),
        ]));

        $this->iShouldHit($myHand, $dealersHand)->shouldReturn(true);
        $this->iShouldDouble($myHand, $dealersHand)->shouldReturn(false);
        $this->iShouldSurrender($myHand, $dealersHand)->shouldReturn(false);
        $this->iShouldStand($myHand, $dealersHand)->shouldReturn(false);

        $dealersHand = Hand::create(CardCollection::make([
            new Card(10, Suit::club()),
        ]));

        $this->iShouldHit($myHand, $dealersHand)->shouldReturn(true);
        $this->iShouldDouble($myHand, $dealersHand)->shouldReturn(false);
        $this->iShouldSurrender($myHand, $dealersHand)->shouldReturn(false);
        $this->iShouldStand($myHand, $dealersHand)->shouldReturn(false);
    }

    public function it_should_hit_when_my_cards_total_9_and_the_dealers_card_is_a_2()
    {
        $myHand = Hand::create(CardCollection::make([
            new Card(4, Suit::club()),
            new Card(5, Suit::diamond()),
        ]));

        $dealersHand = Hand::create(CardCollection::make([
            new Card(2, Suit::club()),
        ]));

        $this->iShouldHit($myHand, $dealersHand)->shouldReturn(true);
        $this->iShouldDouble($myHand, $dealersHand)->shouldReturn(false);
        $this->iShouldSurrender($myHand, $dealersHand)->shouldReturn(false);
        $this->iShouldStand($myHand, $dealersHand)->shouldReturn(false);
    }

    // Double / hit
    public function it_should_double_when_my_cards_total_9_and_the_dealers_card_is_between_3_and_6()
    {
        $myHand = Hand::create(CardCollection::make([
            new Card(4, Suit::club()),
            new Card(5, Suit::diamond()),
        ]));

        for ($i = 3; $i <= 6; $i++) {
            $dealersHand = Hand::create(CardCollection::make([
                new Card($i, Suit::club()),
            ]));

            $this->iShouldDouble($myHand, $dealersHand)->shouldReturn(true);
            $this->iShouldHit($myHand, $dealersHand)->shouldReturn(true);
            $this->iShouldSurrender($myHand, $dealersHand)->shouldReturn(false);
            $this->iShouldStand($myHand, $dealersHand)->shouldReturn(false);
        }
    }

    public function it_should_hit_when_my_cards_total_9_and_the_dealers_card_is_between_7_and_ace()
    {
        $myHand = Hand::create(CardCollection::make([
            new Card(4, Suit::club()),
            new Card(5, Suit::diamond()),
        ]));

        $possibleDealerCards = collect([7,8,9,10,Card::JACK,Card::QUEEN,Card::KING,Card::ACE]);

        $possibleDealerCards->each(function ($value) use ($myHand) {
            $dealersHand = Hand::create(CardCollection::make([
                new Card($value, Suit::club()),
            ]));

            $this->iShouldHit($myHand, $dealersHand)->shouldReturn(true);
            $this->iShouldDouble($myHand, $dealersHand)->shouldReturn(false);
            $this->iShouldSurrender($myHand, $dealersHand)->shouldReturn(false);
            $this->iShouldStand($myHand, $dealersHand)->shouldReturn(false);
        });
    }

    public function it_should_hit_when_my_cards_total_5_through_8()
    {
        for($i=5; $i <= 8; $i++) {
            $myHand = Hand::create(CardCollection::make([
                new Card($i - 3, Suit::club()),
                new Card(3, Suit::diamond()),
            ]));

            $possibleDealerCards = collect([2,3,4,5,6,7,8,9,10,Card::JACK,Card::QUEEN,Card::KING,Card::ACE]);

            $possibleDealerCards->each(function ($value) use ($myHand) {
                $dealersHand = Hand::create(CardCollection::make([
                    new Card($value, Suit::club()),
                ]));

                $this->iShouldHit($myHand, $dealersHand)->shouldReturn(true);
                $this->iShouldDouble($myHand, $dealersHand)->shouldReturn(false);
                $this->iShouldSurrender($myHand, $dealersHand)->shouldReturn(false);
                $this->iShouldStand($myHand, $dealersHand)->shouldReturn(false);
            });
        }
    }
}
