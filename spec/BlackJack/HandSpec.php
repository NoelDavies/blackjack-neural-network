<?php

namespace spec\BlackJack;

use BlackJack\CardCollection;
use NoelDavies\Cards\Card;
use NoelDavies\Cards\Suit;
use PhpSpec\ObjectBehavior;

class HandSpec extends ObjectBehavior
{
    public function it_needs_to_know_when_a_hand_is_blackjack(Card $card1, Card $card2)
    {
        $cards = CardCollection::make([
            new Card(Card::ACE, Suit::club()),
            new Card(10, Suit::diamond()),
        ]);

        $this->beConstructedWith($cards);

        $this->handIsBlackJack()->shouldReturn(true);
    }

    public function it_needs_to_know_when_a_hand_is_not_blackjack()
    {
        $cards = CardCollection::make([
            new Card(Card::ACE, Suit::club()),
            new Card(4, Suit::diamond()),
        ]);

        $this->beConstructedWith($cards);

        $this->handIsBlackJack()->shouldReturn(false);
    }

    public function it_can_provide_the_total_value_of_a_given_2_card_hand()
    {
        $cards = CardCollection::make([
            new Card(10, Suit::club()),
            new Card(4, Suit::diamond()),
        ]);

        $this->beConstructedWith($cards);

        $this->handTotal()->shouldReturn(14);
    }

    public function it_can_provide_the_total_value_of_a_given_3_card_hand()
    {
        $cards = CardCollection::make([
            new Card(2, Suit::club()),
            new Card(4, Suit::diamond()),
            new Card(3, Suit::diamond()),
        ]);

        $this->beConstructedWith($cards);

        $this->handTotal()->shouldReturn(9);
    }

    public function it_can_provide_the_total_value_of_a_given_4_card_hand()
    {
        $cards = CardCollection::make([
            new Card(2, Suit::club()),
            new Card(4, Suit::diamond()),
            new Card(3, Suit::diamond()),
            new Card(5, Suit::diamond()),
        ]);

        $this->beConstructedWith($cards);

        $this->handTotal()->shouldReturn(14);
    }

    public function it_can_provide_the_total_value_of_a_given_5_card_hand()
    {
        $cards = CardCollection::make([
            new Card(2, Suit::club()),
            new Card(4, Suit::diamond()),
            new Card(3, Suit::diamond()),
            new Card(5, Suit::diamond()),
            new Card(2, Suit::spade()),
        ]);

        $this->beConstructedWith($cards);

        $this->handTotal()->shouldReturn(16);
    }

    public function it_can_provide_the_total_value_of_a_2_card_hand_including_an_ace()
    {
        $cards = CardCollection::make([
            new Card(2, Suit::club()),
            new Card(Card::ACE, Suit::diamond()),
        ]);

        $this->beConstructedWith($cards);

        $this->handTotal()->shouldReturn(13);
    }

    public function it_can_reduce_the_value_of_an_ace_if_the_total_normally_would_be_higher_than_21()
    {
        $cards = CardCollection::make([
            new Card(9, Suit::club()),
            new Card(9, Suit::diamond()),
            new Card(Card::ACE, Suit::spade()),
        ]);

        $this->beConstructedWith($cards);

        $this->handTotal()->shouldReturn(19);
    }

    public function it_can_reduce_the_value_of_2_aces_if_the_total_normally_would_be_higher_than_21()
    {
        $cards = CardCollection::make([
            new Card(9, Suit::club()),
            new Card(9, Suit::diamond()),
            new Card(Card::ACE, Suit::spade()),
            new Card(Card::ACE, Suit::diamond()),
        ]);

        $this->beConstructedWith($cards);

        $this->handTotal()->shouldReturn(20);
    }

    public function it_can_return_the_cards()
    {
        $cards = CardCollection::make([
            new Card(9, Suit::club()),
            new Card(9, Suit::diamond()),
            new Card(Card::ACE, Suit::spade()),
            new Card(Card::ACE, Suit::diamond()),
        ]);

        $this->beConstructedWith($cards);

        $this->cards()->shouldReturn($cards);
    }
}
