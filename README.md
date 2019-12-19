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
* @param int[] $parameter array of ints!
 */
$method = function(array $parameter) {

};

$parameters = $extractor->getFunctionParameters(new \ReflectionFunction($method));

$parameters[0]->getDescription(); // array of ints!
$parameters[0]->getTypes()[0]->getBuiltinType() ; // array
$parameters[0]->getTypes()[0]->getClassName() ; // null
$parameters[0]->getTypes()[0]->isCollection() ; // true
$parameters[0]->getTypes()[0]->getCollectionValueType()->getBuiltinType() ; // int
```