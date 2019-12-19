<?php

declare(strict_types=1);

namespace Abryb\ParameterInfo\Util;

use Abryb\ParameterInfo\Type;

/**
 * @author Błażej Rybarkiewicz <b.rybarkiewicz@gmail.com>
 *
 * @internal
 */
class TypeSpecifier
{
    public function specifyType(Type $original, Type $specifying): Type
    {
        $original = $this->specifyIterableOrArray($original, $specifying);

        $original = $this->specifyCollection($original, $specifying);

        $original = $this->specifyNullable($original, $specifying);

        $original = $this->specifyClass($original, $specifying);

        return $original;
    }

    public function nullableSpecify(?Type $original, ?Type $specifying): ?Type
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

        return $this->specifyType($original, $specifying);
    }

    private function specifyIterableOrArray(Type $original, Type $specifying): Type
    {
        if (Type::BUILTIN_TYPE_ITERABLE === $original->getBuiltinType() && Type::BUILTIN_TYPE_ARRAY === $specifying->getBuiltinType()) {
            $original =  new Type(
                Type::BUILTIN_TYPE_ARRAY,
                $original->isNullable(),
                $original->getClassName(),
                $original->isCollection(),
                $original->getCollectionKeyType(),
                $original->getCollectionValueType()
            );
        }

        return $original;
    }

    private function specifyCollection(Type $original, Type $specifying): Type
    {
        $isCollection = $original->isCollection() || $specifying->isCollection();
        $keyType      = $this->nullableSpecify($original->getCollectionKeyType(), $specifying->getCollectionKeyType());
        $valueType    = $this->nullableSpecify($original->getCollectionValueType(), $specifying->getCollectionValueType());

        return new Type(
            $original->getBuiltinType(),
            $original->isNullable(),
            $original->getClassName(),
            $isCollection,
            $keyType,
            $valueType
        );
    }

    private function specifyNullable(Type $original, Type $specifying) : Type
    {
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

    private function specifyClass(Type $original, Type $specifying) : Type
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
