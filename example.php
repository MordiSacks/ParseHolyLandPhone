<?php

use ParseHolyLandPhone\ParsePhone;

require_once 'vendor/autoload.php';

// via new instance
$number = new ParsePhone('025121234');

// via static method
$number = ParsePhone::create('025121234');

$number->isValid();

$number->isNotValid();
