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

// TODO add more tests
