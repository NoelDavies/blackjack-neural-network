<?php

use BlackJack\CardCollection;
use BlackJack\CasinoDeckProvider;
use BlackJack\Hand;
use BlackJack\Strategy;
use NoelDavies\Cards\Deck;

require_once __DIR__ . '/../vendor/autoload.php';

$numberOfDecksToUse  = 10000;
$numberOfHandsToDeal = ($numberOfDecksToUse * 52) / 3;
$numberOfInputs      = 3; // Player Card 1, Player Card 2, Dealer's Face Up Card
$numberOfOutputs     = 3; // Hit, Stand, Surrender

$deck = new Deck(new CasinoDeckProvider($numberOfDecksToUse));
$deck->shuffle();

/**
 * <number of hands> 3 3
 * <card-1> <card-2> <dealer-card>
 * <stand> <hit> <surrender>
 */

printf('%d %d %d' . "\n", $numberOfHandsToDeal, $numberOfInputs, $numberOfOutputs);

for ($i = 1; $i < $numberOfHandsToDeal; $i++) {
    $cards        = CardCollection::make($deck->drawHand(2));
    $dealersCards = CardCollection::make($deck->drawHand(1));

    $hand        = Hand::create($cards);
    $dealersHand = Hand::create($dealersCards);

    printf('%d %d %d' . "\n", $cards->get(0)->numericKey(), $cards->get(1)->numericKey(), $dealersCards->get(0)->numericKey());
    printf('%d %d %d' . "\n",
        Strategy::iShouldStand($hand, $dealersHand),
        Strategy::iShouldHit($hand, $dealersHand),
        Strategy::iShouldSurrender($hand, $dealersHand)
    );
}
