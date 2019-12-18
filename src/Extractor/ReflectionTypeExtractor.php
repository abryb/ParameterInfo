<?php

declare(strict_types=1);

namespace Abryb\ParameterInfo\Extractor;

use Abryb\ParameterInfo\ParameterTypeExtractorInterface;
use Abryb\ParameterInfo\Type;

/**
 * @author Błażej Rybarkiewicz <b.rybarkiewicz@gmail.com>
 */
class ReflectionTypeExtractor implements ParameterTypeExtractorInterface
{
    /**
     * {@inheritdoc}
     */
    public function extractTypes(\ReflectionParameter $parameter): array
    {
        if (!$parameter->hasType()) {
            return null;
        }
        if ($parameter->getType()->isBuiltin()) {
            $type = (string) $parameter->getType();
        } else {
            $type = $parameter->getClass();
        }

        return [new Type($type, $parameter->allowsNull())];
    }
}
