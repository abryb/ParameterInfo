<?php

declare(strict_types=1);

namespace Abryb\ParameterInfo\Extractor;

use Abryb\ParameterInfo\ParameterTypeExtractorInterface;
use Abryb\ParameterInfo\Type;
use Abryb\ParameterInfo\Util\TypeCollection;
use Abryb\ParameterInfo\Util\TypeComparator;

/**
 * @author Błażej Rybarkiewicz <b.rybarkiewicz@gmail.com>
 */
class MergingTypeExtractor implements ParameterTypeExtractorInterface
{
    /**
     * @var iterable|ParameterTypeExtractorInterface[]
     */
    private $typeExtractors;

    /**
     * StrictTypeExtractor constructor.
     *
     * @param iterable|ParameterTypeExtractorInterface[] $typeExtractors
     */
    public function __construct(iterable $typeExtractors)
    {
        $this->typeExtractors = $typeExtractors;
    }

    /**
     * {@inheritdoc}
     */
    public function extractTypes(\ReflectionParameter $parameter): array
    {
        $types = new TypeCollection();

        foreach ($this->typeExtractors as $typeExtractor) {
            foreach ($typeExtractor->extractTypes($parameter) as $extractedType) {
                if (!$types->contains($extractedType)) {
                    $types->add($extractedType);
                }
            }
        }

        return $types->toArray();
    }
}
