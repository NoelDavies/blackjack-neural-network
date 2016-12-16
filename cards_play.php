<?php

use noeldavies\Cards\Card;
use noeldavies\Cards\Deck;

require_once __DIR__ . '/vendor/autoload.php';

$deck = new Deck();

$deck->shuffle();

for ($i = 1; $i < 26; $i++) {
    $cards = $deck->drawHand(2);

    $handIsGood = BlackJack::create($cards[0], $cards[1])->handIsGood();
    $outputValue = $handIsGood ?: -1;

    printf('%d %d %s', $cards[0]->value(), $cards[1]->value(), "\n");
    printf('%d %s', $outputValue, "\n");
}
