### Installation

```shell script
composer require abryb/parameter-info
```

### Usage

```php
<?php

use Abryb\ParameterInfo\ParameterInfoExtractorFactory;

$extractor = ParameterInfoExtractorFactory::create();

/**
 * @param object|null                          $a0 very object description. Important!
 * @param \DateInterval[]|\DateTime[]|iterable $a1
 */
$function = function ($a0, iterable $a1) {
    // ...
};

$parameters = $extractor->getMethodParameters(new \ReflectionFunction($function));

$parameters[0]->getDescription(); // very object description. Important!
$parameters[0]->getTypes()[0]->getBuiltinType(); // object
$parameters[0]->getTypes()[0]->isNullable(); // true
$parameters[0]->getTypes()[0]->getClassName(); // null
$parameters[0]->getTypes()[0]->isCollection(); // false

$parameters[1]->getTypes()[0]->getBuiltinType(); // iterable
$parameters[0]->getTypes()[0]->isCollection(); // true

$parameters[1]->getTypes()[0]->getCollectionValueType()->getClassName(); // DateTime

$parameters[1]->getTypes()[1]->getCollectionValueType()->getClassName(); // DateInterval

```