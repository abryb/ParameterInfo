<?php

declare(strict_types=1);

namespace Abryb\ParameterInfo\Util;

use Abryb\ParameterInfo\Type;

/**
 * @author Błażej Rybarkiewicz <b.rybarkiewicz@gmail.com>
 *
 * @internal
 */
final class TypeSpecifier
{
    public function specifyType(?Type $original, ?Type $specifying): ?Type
    {
        if (null === $original && null === $specifying) {
            return null;
        }
        if (null === $specifying) {
            return $original;
        }
        if (null === $original) {
            return $specifying;
        }

        return $this->doSpecifyType($original, $specifying);
    }

    private function doSpecifyType(Type $original, Type $specifying): Type
    {
        $original = $this->specifyCollection($original, $specifying);

        $original = $this->specifyNullable($original, $specifying);

        return $this->specifyClass($original, $specifying);
    }

    private function specifyCollection(Type $original, Type $specifying): Type
    {
        $collectionTypes = [Type::BUILTIN_TYPE_ITERABLE, Type::BUILTIN_TYPE_ARRAY, Type::BUILTIN_TYPE_OBJECT];

        if (!\in_array($original->getBuiltinType(), $collectionTypes) || !\in_array($specifying->getBuiltinType(), $collectionTypes)) {
            return $original;
        }

        $isCollection        = $original->isCollection() || $specifying->isCollection();
        $collectionKeyType   = $this->specifyType($original->getCollectionKeyType(), $specifying->getCollectionKeyType());
        $collectionValueType = $this->specifyType($original->getCollectionValueType(), $specifying->getCollectionValueType());

        return new Type(
            $original->getBuiltinType(),
            $original->isNullable(),
            $original->getClassName(),
            $isCollection,
            $collectionKeyType,
            $collectionValueType
        );
    }

    private function specifyNullable(Type $original, Type $specifying): Type
    {
        if ($original->getBuiltinType() !== $specifying->getBuiltinType()) {
            return $original;
        }

        $nullable = $original->isNullable() && $specifying->isNullable();

        return new Type(
            $original->getBuiltinType(),
            $nullable,
            $original->getClassName(),
            $original->isCollection(),
            $original->getCollectionKeyType(),
            $original->getCollectionValueType()
        );
    }

    private function specifyClass(Type $original, Type $specifying): Type
    {
        if (null === $specifying->getClassName() || $original->getClassName() === $specifying->getClassName()) {
            return $original;
        }
        if (null === $original->getClassName() || is_subclass_of($specifying->getClassName(), $original->getClassName())) {
            return new Type(
                $original->getBuiltinType(),
                $original->isNullable(),
                $specifying->getClassName(),
                $original->isCollection(),
                $original->getCollectionKeyType(),
                $original->getCollectionValueType()
            );
        }

        return $original;
    }
}
