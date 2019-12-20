<?php

declare(strict_types=1);

namespace Abryb\ParameterInfo\Extractor;

use Abryb\ParameterInfo\ParameterTypeExtractorInterface;
use Abryb\ParameterInfo\Type;

/**
 * @author Błażej Rybarkiewicz <b.rybarkiewicz@gmail.com>
 */
final class ReflectionTypeExtractor implements ParameterTypeExtractorInterface
{
    /**
     * {@inheritdoc}
     */
    public function getTypes(\ReflectionParameter $parameter): array
    {
        $type = $parameter->getType();

        if (null === $type || !$type instanceof \ReflectionNamedType) {
            return [];
        }

        if (!$type->isBuiltin()) {
            return [new Type(Type::BUILTIN_TYPE_OBJECT, $parameter->allowsNull(), $type->getName())];
        }

        return [new Type($type->getName(), $parameter->allowsNull())];
    }
}
