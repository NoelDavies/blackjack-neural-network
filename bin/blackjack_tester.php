<?php
use BlackJack\CardCollection;
use BlackJack\CasinoDeckProvider;
use BlackJack\Hand;
use BlackJack\Strategy;
use NoelDavies\Cards\Deck;

require_once __DIR__ . '/../vendor/autoload.php';

$deck = new Deck(new CasinoDeckProvider());
$deck->shuffle();

$train_file = (__DIR__ . "/../blackjack.net");

if (!is_file($train_file)) {
    die("The file blackjack.net has not been created! Please run simple_train.php to generate it" . PHP_EOL);
}

$ann = fann_create_from_file($train_file);

if ($ann) {

    $deck->shuffle();

    for ($i = 1; $i < 20; $i++) {

        $cards        = CardCollection::make($deck->drawHand(2));
        $dealersCards = CardCollection::make($deck->drawHand(1));
        $input        = [$cards->get(0)->numericKey(), $cards->get(1)->numericKey(), $dealersCards->get(0)->numericKey()];

        $hand        = Hand::create($cards);
        $dealersHand = Hand::create($dealersCards);

        $calc_out = fann_run($ann, $input);

        if (Strategy::iShouldStand($hand, $dealersHand) === false
            && Strategy::iShouldHit($hand, $dealersHand) === false
            && Strategy::iShouldSurrender($hand, $dealersHand) === false
        ) {
            continue;
        }

        printf('I was deault %s and %s - it is %s blackjack' . "\n",
            $cards->get(0),
            $cards->get(1),
            $calc_out[0] ? '' : 'not'
        );

        printf(
            'The Dealer shows a %s' . "\n" .
            'I should %s stand' . "\n" .
            'I should %s hit' . "\n" .
            'I should %s surrender' . "\n\n",
            $dealersCards->get(0),
            Strategy::iShouldStand($hand, $dealersHand),
            Strategy::iShouldHit($hand, $dealersHand),
            Strategy::iShouldSurrender($hand, $dealersHand)
        );

        printf('I decide to: %s', getMyDecision($calc_out));
    }
    fann_destroy($ann);
} else {
    die("Invalid file format" . PHP_EOL);
}
function getDecision(Hand $hand, Hand $dealersHand) {
    if (Strategy::iShouldStand($hand, $dealersHand)) {
        return 'stand';
    }
    if (Strategy::iShouldHit($hand, $dealersHand)) {
        return 'hit';
    }
    if (Strategy::iShouldSurrender($hand, $dealersHand)) {
        return 'surrender';
    }

    return 'do nothing.. I don\'t know enough yet';
}

function getMyDecision($calc_out) {
    var_dump($calc_out);exit;
}
