# ParseHolyLandPhone
Parse Holy land (Israel/Palestine) phone numbers

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
* `isLanLine` Checks if phone number is LanLine.
* `isSpecial` Checks if phone number is Special (*1234).
* `isMobile` Checks if phone number is Mobile.
* `isBusiness` Checks if phone number is Business (1700, 1800, etc).
* `isTollFree` Checks if phone number is TollFree (1800, etc).
* `isPremium` Checks if phone number is Premium (1900, etc).
* `isErotic` Checks if phone number is Erotic (1919).
* `getInternational` Returns phone number transformed to international format 025231234  > 97225231234.
* `getPhoneNumber` Returns the parsed phone number.
