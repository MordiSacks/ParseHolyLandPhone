# ParseHolyLandPhone
Parse Holy land (Israel/Palestine) phone numbers


[![Latest Version on Packagist](https://img.shields.io/packagist/v/parse-holy-land-phone/parse-phone.svg?style=flat-square)](https://packagist.org/packages/parse-holy-land-phone/parse-phone)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/MordiSacks/ParseHolyLandPhone/run-tests.yml?branch=master&label=tests&style=flat-square)](https://github.com/MordiSacks/ParseHolyLandPhone/actions?query=workflow%3Arun-tests+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/parse-holy-land-phone/parse-phone.svg?style=flat-square)](https://packagist.org/packages/parse-holy-land-phone/parse-phone)


# Installation
``` 
composer require parse-holy-land-phone/parse-phone
```

## usage
```php
// via new instance
$number = new ParsePhone('025121234');

// via static method
$number = ParsePhone::create('025121234');

$number->isValid();
```

## Available methods
* `isValid` Checks if phone number is a valid Israeli/Palestinian phone number.
* `isIsraeli` Checks if phone number is Israeli.
* `isPalestinian` Checks if phone number is Palestinian.
* `isLandLine` Checks if phone number is LandLine.
* `isSpecial` Checks if phone number is Special (*1234).
* `isMobile` Checks if phone number is Mobile.
* `isBusiness` Checks if phone number is Business (1700, 1800, etc).
* `isTollFree` Checks if phone number is TollFree (1800, etc).
* `isPremium` Checks if phone number is Premium (1900, etc).
* `isKosher` Checks if phone number is Kosher (phone supports only calls).
* `isErotic` Checks if phone number is Erotic (1919).
* `isSmsable` Checks if phone number can receive an sms (text) .
* `getInternational` Returns phone number transformed to international format 025231234  > 97225231234.
* `getLocal` Returns phone number transformed to local format 97225231234 > 025231234.
* `getPhoneNumber` Returns the parsed phone number.
### all `is` functions have a reverse function `isNot`.

## Community contributors
* Biny Yawitz 