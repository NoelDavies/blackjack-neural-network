<?php

$num_input              = 3;
$num_output             = 3;
$num_layers             = 5;
$num_neurons_hidden     = 107;
$desired_error          = 0.00001;
$max_epochs             = 5000000;
$epochs_between_reports = 10;

$ann = fann_create_standard($num_layers, $num_input, $num_neurons_hidden, $num_neurons_hidden, $num_neurons_hidden,
    $num_output);

if ($ann) {
    echo 'Training Blackjack..';
    fann_set_activation_function_hidden($ann, FANN_SIGMOID_SYMMETRIC);
    fann_set_activation_function_output($ann, FANN_SIGMOID_SYMMETRIC);

    $filename = __DIR__ . '/../blackjack_hands.data';
    if (fann_train_on_file($ann, $filename, $max_epochs, $epochs_between_reports, $desired_error)) {
        print('blackjack trained.' . PHP_EOL);
    }

    if (fann_save($ann, __DIR__ . "/../blackjack.net")) {
        print('blackjack.net saved. Check it out!' . PHP_EOL);
    }

    fann_destroy($ann);
}
