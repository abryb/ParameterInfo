<?php

declare(strict_types=1);

namespace Abryb\ParameterInfo;

/**
 * @author Błażej Rybarkiewicz <b.rybarkiewicz@gmail.com>
 */
class ParameterInfoExtractor implements ParameterInfoExtractorInterface
{
    /**
     * @var ParameterTypeExtractorInterface
     */
    private $typeExtractor;
    /**
     * @var ParameterDescriptionExtractorInterface
     */
    private $descriptionExtractor;

    /**
     * ParameterInfoExtractor constructor.
     */
    public function __construct(
        ParameterTypeExtractorInterface $typeExtractor,
        ParameterDescriptionExtractorInterface $descriptionExtractor
    )
    {
        $this->typeExtractor        = $typeExtractor;
        $this->descriptionExtractor = $descriptionExtractor;
    }

    public function getInfo(\ReflectionParameter $parameter): ParameterInfo
    {
        return new ParameterInfo(
            $parameter,
            $this->typeExtractor->getTypes($parameter),
            $this->descriptionExtractor->getDescription($parameter)
        );
    }
}
