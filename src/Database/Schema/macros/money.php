<?php


use Illuminate\Database\Schema\Blueprint;

/*
 * Money
 */
Blueprint::macro('amount', function($label = 'amount') {
    return $this->bigInteger($label)
        ->nullable()
        ->default(0)
        ->comment('Big amount of money');
});

Blueprint::macro('smallAmount', function($label = 'amount') {
    return $this->integer($label)
        ->nullable()
        ->default(0)
        ->comment('Small amount of money');
});