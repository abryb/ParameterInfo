<?php

declare(strict_types=1);


namespace Abryb\ParameterInfo;


use Abryb\ParameterInfo\Extractor\PhpDocExtractor;
use Abryb\ParameterInfo\Extractor\ReflectionTypeExtractor;
use Abryb\ParameterInfo\Extractor\SpecifyingTypeExtractor;
use Abryb\ParameterInfo\Util\TypeSpecifier;
use Phpro\SoapClient\CodeGenerator\Model\Parameter;

/**
 * @author Błażej Rybarkiewicz <b.rybarkiewicz@gmail.com>
 */
final class ParameterInfoExtractorFactory
{
    public static function create() : ParameterInfoExtractorInterface
    {
        $phpDocExtractor = new PhpDocExtractor();
        $reflectionTypeExtractor = new ReflectionTypeExtractor();
        $specifyingTypeExtractor = new SpecifyingTypeExtractor(
            $reflectionTypeExtractor,
            $phpDocExtractor,
            new TypeSpecifier()
        );

        return new ParameterInfoExtractor($specifyingTypeExtractor, $phpDocExtractor);
    }
}