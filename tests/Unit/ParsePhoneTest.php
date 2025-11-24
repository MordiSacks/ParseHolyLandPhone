<?php

use ParseHolyLandPhone\ParsePhone;

test('creates an instance via static call', function () {
    $number = ParsePhone::create('025555555');
    expect($number)->toBeInstanceOf(ParsePhone::class);
});

test('creates an instance via new', function () {
    $number = new ParsePhone('025555555');
    expect($number)->toBeInstanceOf(ParsePhone::class);
});

test('removes any non digit from number', function () {
    $number = new ParsePhone('02-(555)-5555');
    expect($number->getPhoneNumber())->toBe('025555555');
});

test('converts to local format', function () {
    $number = new ParsePhone('+972 2-(555)-5555');
    expect($number->getPhoneNumber())->toBe('025555555');
});

test('has isNot methods for all is methods', function () {
    $number = new ParsePhone('+972 2-(555)-5555');
    $isMethods = array_map(
        function ($method) { return substr($method->getName(), 2); },
        array_filter(
            (new ReflectionClass($number))->getMethods(ReflectionMethod::IS_PUBLIC),
            function ($method) { return substr($method->getName(), 0, 2) === 'is'; }
        )
    );

    foreach ($isMethods as $method) {
        expect($number->{'isNot' . $method}())->toBeBool();
    }
});

test('validates an valid israeli phone number as israeli', function () {
    $number = ParsePhone::create('025555555');
    expect($number->isValid())->toBeTrue();
});

// test kosher and valid numbers for all providers
test('validates isKosher/isValid numbers', function () {
    $nonKosherNumbers = [
        '0527000000',
        '0522000000',
        '0548200000',
        '0555000000',
        '0505000000',
        '0554110000',
        '0504050000',
        '0507610000',
        '0512356666',
        '0526775512',
        '0534516548',
        '0546154485',
        '0548312654',
        '0555641358',
        '0554955555',
        '0586451235',
        '0795416586',
        '023549878',
        '086548745',
        '0738888888',
    ];

    foreach ($nonKosherNumbers as $n) {
        $number = ParsePhone::create($n);
        expect($number->isValid())->toBeTrue("isValid failed for number: $n (got: " . var_export($number->isValid(), true) . ")");
        expect($number->isKosher())->toBeFalse("isKosher failed for number: $n (got: " . var_export($number->isKosher(), true) . ")");
    }

    // test invalid numbers
    $invalidNumbers = [
        '052760000',
        '0527164xqwd32',
        '055410223--000',
        '0548465666666',
        '08801111111',
        '0526987797974'
    ];

    foreach ($invalidNumbers as $n) {
        $number = ParsePhone::create($n);
        expect($number->isValid())->toBeFalse("isValid failed for invalid number: $n (got: " . var_export($number->isValid(), false) . ")");
        expect($number->isKosher())->toBeFalse("isKosher failed for number: $n (got: " . var_export($number->isKosher(), false) . ")");
    }
    

    // 53 - Hot Mobile
    $n = '0533100000';
    $number = ParsePhone::create($n);
    expect($number->isValid())->toBeTrue("isValid failed for $n");
    expect($number->isKosher())->toBeTrue("isKosher failed for $n");

    // 5567 - Rami Levy
    $n = '0556700000';
    $number = ParsePhone::create($n);
    expect($number->isValid())->toBeTrue("isValid failed for $n");
    expect($number->isKosher())->toBeTrue("isKosher failed for $n");

    // 5540x - Rami Levy (55400–55402)
    foreach (['55400', '55401', '55402'] as $p) {
        $n = '0' . $p . '0000';
        $number = ParsePhone::create($n);
        expect($number->isValid())->toBeTrue("isValid failed for $n");
        expect($number->isKosher())->toBeTrue("isKosher failed for $n");
    }

    // 55760 - Telzar
    $n = '0557600000';
    $number = ParsePhone::create($n);
    expect($number->isValid())->toBeTrue("isValid failed for $n");
    expect($number->isKosher())->toBeTrue("isKosher failed for $n");

    // 55410 - Merkazia
    $n = '0554100000';
    $number = ParsePhone::create($n);
    expect($number->isValid())->toBeTrue("isValid failed for $n");
    expect($number->isKosher())->toBeTrue("isKosher failed for $n");

    // 5041 - Pelephone
    $n = '0504100000';
    $number = ParsePhone::create($n);
    expect($number->isValid())->toBeTrue("isValid failed for $n");
    expect($number->isKosher())->toBeTrue("isKosher failed for $n");

    // 5832 - Golan
    $n = '0583200000';
    $number = ParsePhone::create($n);
    expect($number->isValid())->toBeTrue("isValid failed for $n");
    expect($number->isKosher())->toBeTrue("isKosher failed for $n");

    // 5532 - Free Telecom
    $n = '0553200000';
    $number = ParsePhone::create($n);
    expect($number->isValid())->toBeTrue("isValid failed for $n");
    expect($number->isKosher())->toBeTrue("isKosher failed for $n");

    // 5552 - Annatel
    $n = '0555200000';
    $number = ParsePhone::create($n);
    expect($number->isValid())->toBeTrue("isValid failed for $n");
    expect($number->isKosher())->toBeTrue("isKosher failed for $n");

    // 53x - hot mobile
    foreach (['5331', '5341'] as $p) {
        $n = '0' . $p . '00000';
        $number = ParsePhone::create($n);
        expect($number->isValid())->toBeTrue("isValid failed for $n");
        expect($number->isKosher())->toBeTrue("isKosher failed for $n");
    }

    // 527x - cellcom
    foreach (['5276', '5271'] as $p) {
        $n = '0' . $p . '00000';
        $number = ParsePhone::create($n);
        expect($number->isValid())->toBeTrue("isValid failed for $n");
        expect($number->isKosher())->toBeTrue("isKosher failed for $n");
    }

    // 548x - partner
    foreach (['5484', '5485'] as $p) {
        $n = '0' . $p . '00000';
        $number = ParsePhone::create($n);
        expect($number->isValid())->toBeTrue("isValid failed for $n");
        expect($number->isKosher())->toBeTrue("isKosher failed for $n");
    }

    // Bezeq landline: 0280 / 0380 / 0480 / 0980
    foreach (['0280', '0380', '0480', '0980'] as $p) {
        $n = $p . '00000';
        $number = ParsePhone::create($n);
        expect($number->isValid())->toBeTrue("isValid failed for $n");
        expect($number->isKosher())->toBeTrue("isKosher failed for $n");
    }
});

// TODO add more tests
