# IBAN library

[![Build Status](https://img.shields.io/travis/com/RikudouSage/IBAN/master.svg)](https://travis-ci.com/RikudouSage/IBAN)
[![Coverage Status](https://img.shields.io/coveralls/github/RikudouSage/IBAN/master.svg)](https://coveralls.io/github/RikudouSage/IBAN?branch=master)
[![Download](https://img.shields.io/packagist/dt/rikudou/iban.svg)](https://packagist.org/packages/rikudou/iban)


## Installation

Via composer: `composer require rikudou/iban`

## Usage

There are two validators and two iban implementations, one generic and one for
Czech accounts.

### Generic IBAN

```php
<?php

use Rikudou\Iban\Iban\IBAN;

$iban = new IBAN('CZ5530300000001325090010');

echo $iban->asString(); // prints the iban
echo strval($iban); // the same as above

```

### Generic IBAN validator

```php
<?php

use Rikudou\Iban\Iban\IBAN;

$iban = new IBAN('CZ5530300000001325090010');

$validator = $iban->getValidator(); // returns instance of GenericIbanValidator

if(!$validator->isValid()) {
    // do something on invalid iban
}
```

### Czech IBAN

Construct IBAN from Czech account number and bank code

```php
<?php

use Rikudou\Iban\Iban\CzechIbanAdapter;

$iban = new CzechIbanAdapter('1325090010', '3030');

echo $iban->asString(); // prints CZ5530300000001325090010

```

### Czech IBAN validator

```php
<?php

use Rikudou\Iban\Iban\CzechIbanAdapter;

$iban = new CzechIbanAdapter('1325090010', '3030');

// returns an instance of CompoundValidator which contains
// CzechIbanValidator and GenericIbanValidator
$validator = $iban->getValidator();

if(!$validator->isValid()) {
    // do something
}
```
