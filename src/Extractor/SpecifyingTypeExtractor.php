<?php

declare(strict_types=1);

namespace Abryb\ParameterInfo\Extractor;

use Abryb\ParameterInfo\ParameterTypeExtractorInterface;
use Abryb\ParameterInfo\Util\TypeCollection;
use Abryb\ParameterInfo\Util\TypeComparator;
use Abryb\ParameterInfo\Util\TypeSpecifier;

/**
 * @author Błażej Rybarkiewicz <b.rybarkiewicz@gmail.com>
 */
final class SpecifyingTypeExtractor implements ParameterTypeExtractorInterface
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
     * @var TypeComparator
     */
    private $typeComparator;

    /**
     * StrictTypeExtractor constructor.
     */
    public function __construct(
        ParameterTypeExtractorInterface $mainExtractor,
        ParameterTypeExtractorInterface $specifyingExtractor
    )
    {
        $this->mainExtractor       = $mainExtractor;
        $this->specifyingExtractor = $specifyingExtractor;
        $this->typeSpecifier       = new TypeSpecifier();
        $this->typeComparator      = new TypeComparator();
    }

    /**
     * {@inheritdoc}
     */
    public function getTypes(\ReflectionParameter $parameter): array
    {
        $originalTypes = $this->mainExtractor->getTypes($parameter);
        $specifying    = $this->specifyingExtractor->getTypes($parameter);

        if (empty($originalTypes)) {
            return (new TypeCollection($specifying))->unique()->toArray();
        }

        $result = new TypeCollection();
        foreach ($originalTypes as $o) {
            foreach ($specifying as $s) {
                $r = $this->typeSpecifier->specifyType($o, $s);

                if (!$this->typeComparator->typesAreEqual($r, $o)) { // so specifier did something
                    if (!$result->contains($r)) {
                        $result->add($r);
                    }
                }
            }
        }

        return $result->generalize()->toArray();
    }
}
