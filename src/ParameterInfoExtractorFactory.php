<?php

declare(strict_types=1);


namespace Abryb\ParameterInfo;


use Abryb\ParameterInfo\Extractor\PhpDocExtractor;
use Abryb\ParameterInfo\Extractor\ReflectionTypeExtractor;
use Abryb\ParameterInfo\Extractor\SpecifyingTypeExtractor;

/**
 * @author Błażej Rybarkiewicz <b.rybarkiewicz@gmail.com>
 */
final class ParameterInfoExtractorFactory
{
    public static function create() : ParameterInfoExtractorInterface
    {
        $phpDocExtractor         = new PhpDocExtractor();

        $specifyingTypeExtractor = new SpecifyingTypeExtractor(
            new ReflectionTypeExtractor(),
            $phpDocExtractor
        );

        return new ParameterInfoExtractor($specifyingTypeExtractor, $phpDocExtractor);
    }
}