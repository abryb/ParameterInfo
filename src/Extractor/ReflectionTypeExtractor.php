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
    public function getTypes(\ReflectionParameter $parameter): array
    {
        if (!$parameter->hasType()) {
            return null;
        }
        if (!$parameter->getType()->isBuiltin()) {
            return [new Type(Type::BUILTIN_TYPE_OBJECT, $parameter->allowsNull(), $parameter->getClass()->getName())];
        }

        return [new Type((string) $parameter->getType(), $parameter->allowsNull())];
    }
}
