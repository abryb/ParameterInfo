<?php

declare(strict_types=1);

namespace Abryb\ParameterInfo;

/**
 * @author Błażej Rybarkiewicz <b.rybarkiewicz@gmail.com>
 */
class ParameterInfoExtractor implements ParameterInfoExtractorInterface
{
    /**
     * @var array|ParameterTypeExtractorInterface[]
     */
    private $typeExtractors;
    /**
     * @var array|ParameterDescriptionExtractorInterface[]
     */
    private $descriptionExtractors;

    /**
     * ParameterInfoExtractor constructor.
     *
     * @param iterable|ParameterTypeExtractorInterface[]        $typeExtractors
     * @param iterable|ParameterDescriptionExtractorInterface[] $descriptionExtractors
     */
    public function __construct(
        iterable $typeExtractors = [],
        iterable $descriptionExtractors = []
    )
    {
        $this->typeExtractors        = $typeExtractors;
        $this->descriptionExtractors = $descriptionExtractors;
    }

    public function extractInfo(\ReflectionParameter $parameter): ParameterInfo
    {
        $types = $this->doExtract($this->typeExtractors, 'extractTypes', [$parameter]);

        $description = $this->doExtract($this->typeExtractors, 'description', [$parameter]);

        return new ParameterInfo($parameter, $types, $description);
    }

    /**
     * Iterates over registered extractors and return the first value found.
     */
    private function doExtract(iterable $extractors, string $method, array $arguments)
    {
        foreach ($extractors as $extractor) {
            if (null !== $value = $extractor->{$method}(...$arguments)) {
                return $value;
            }
        }

        return null;
    }
}
