# IBAN library

[![Tests](https://github.com/RikudouSage/IBAN/actions/workflows/test.yaml/badge.svg)](https://github.com/RikudouSage/IBAN/actions/workflows/test.yaml)
[![Coverage Status](https://img.shields.io/coveralls/github/RikudouSage/IBAN/master.svg)](https://coveralls.io/github/RikudouSage/IBAN?branch=master)
[![Download](https://img.shields.io/packagist/dt/rikudou/iban.svg)](https://packagist.org/packages/rikudou/iban)


## Installation

Via composer: `composer require rikudou/iban`

## Usage

There are multiple IBAN implementations:

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

if (!$validator->isValid()) {
    // do something
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

if (!$validator->isValid()) {
    // do something
}
```

### Slovak IBAN

Construct IBAN from Slovak account number and bank code

```php
<?php

use Rikudou\Iban\Iban\SlovakIbanAdapter;

$iban = new SlovakIbanAdapter('1325090010', '0900');

echo $iban->asString(); // prints SK5009000000001325090010

```

### Slovak IBAN validator

```php
<?php

use Rikudou\Iban\Iban\SlovakIbanAdapter;

$iban = new SlovakIbanAdapter('1325090010', '0900');

// currently returns just an instance of GenericIbanValidator
$validator = $iban->getValidator();

if (!$validator->isValid()) {
    // do something
}
```

### Hungarian IBAN

```php
<?php

use Rikudou\Iban\Iban\HungarianIbanAdapter;

$iban = new HungarianIbanAdapter('11773016-11111018');

echo $iban->asString(); // prints HU42117730161111101800000000
```

### Hungarian IBAN validator

```php
<?php

use Rikudou\Iban\Iban\HungarianIbanAdapter;

$iban = new HungarianIbanAdapter('11773016-11111018');

// returns an instance of CompoundValidator which contains
// HungarianIbanValidator and GenericIbanValidator
$validator = $iban->getValidator();

if (!$validator->isValid()) {
    // do something
}
```
