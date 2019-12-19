<?php

declare(strict_types=1);

namespace Abryb\ParameterInfo\Extractor;

use Abryb\ParameterInfo\ParameterTypeExtractorInterface;
use Abryb\ParameterInfo\Util\TypeSpecifier;

/**
 * @author Błażej Rybarkiewicz <b.rybarkiewicz@gmail.com>
 */
class SpecifyingTypeExtractor implements ParameterTypeExtractorInterface
{
    /**
     * @var ParameterTypeExtractorInterface
     */
    private $mainExtractor;

    /**
     * @var ParameterTypeExtractorInterface
     */
    private $specifyingExtractor;

    /**
     * @var TypeSpecifier
     */
    private $typeSpecifier;

    /**
     * StrictTypeExtractor constructor.
     */
    public function __construct(ParameterTypeExtractorInterface $mainExtractor, ParameterTypeExtractorInterface $specifyingExtractor, TypeSpecifier $typeSpecifier)
    {
        $this->mainExtractor       = $mainExtractor;
        $this->specifyingExtractor = $specifyingExtractor;
        $this->typeSpecifier       = $typeSpecifier;
    }

    /**
     * {@inheritdoc}
     */
    public function getTypes(\ReflectionParameter $parameter): array
    {
        $originalTypes = $this->mainExtractor->getTypes($parameter);
        $specifying = $this->specifyingExtractor->getTypes($parameter);

        $result = [];
        foreach ($originalTypes as $o) {
            foreach ($specifying as $s) {
                $result[] = $this->typeSpecifier->specifyType($o, $s);
            }
        }

        return $result;
    }
}
