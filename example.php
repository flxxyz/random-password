<?php

require_once 'vendor/autoload.php';

use RandomPassword\Password;


$pass = new Password(1, 6);

$password = $pass->ignore('special_symbols')
    ->count(2)
    ->ucfirst()
    ->generate();
echo $password;

$password = $pass->count(1)->generate();
echo $password;


$passwords = $pass->passwords();
var_dump($passwords);

