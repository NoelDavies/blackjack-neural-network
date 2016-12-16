<?php
use Fust\Cards\Deck;

require_once __DIR__ . '/vendor/autoload.php';

$deck = new Deck();

$deck->shuffle();

$train_file = (__DIR__ . "/blackjack.net");
if (!is_file($train_file))
    die("The file blackjack.net has not been created! Please run simple_train.php to generate it" . PHP_EOL);

$ann = fann_create_from_file($train_file);

if ($ann) {

    $deck->shuffle();

    for ($i = 1; $i < 26; $i++) {
        $cards = $deck->drawHand(2);

        $input = [$cards[0]->value(), $cards[1]->value()];

        $calc_out = fann_run($ann, $input);
        printf("xor test (%f,%f) -> %f\n", $input[0], $input[1], $calc_out[0]);
    }
    fann_destroy($ann);
} else {
    die("Invalid file format" . PHP_EOL);
}
