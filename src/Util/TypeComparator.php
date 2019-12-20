<?php

declare(strict_types=1);

namespace Abryb\ParameterInfo\Util;

use Abryb\ParameterInfo\Type;

/**
 * @author Błażej Rybarkiewicz <b.rybarkiewicz@gmail.com>
 *
 * @internal
 */
final class TypeComparator
{
    public function typesAreEqual(Type $a, Type $b): bool
    {
        return
            $a->getBuiltinType() === $b->getBuiltinType()
            && $a->isNullable() === $b->isNullable()
            && $a->getClassName() === $b->getClassName()
            && $a->isCollection() === $b->isCollection()
            && $this->nullableTypesAreEqual($a->getCollectionKeyType(), $b->getCollectionKeyType())
            && $this->nullableTypesAreEqual($a->getCollectionValueType(), $b->getCollectionValueType());
    }

    public function firstTypeIsMoreGeneralThanSecond(Type $a, Type $b): bool
    {
        if ($this->typesAreEqual($a, $b)) {
            return false;
        }

        // a is nullable version of b
        $notNullableA = new Type($a->getBuiltinType(), false, $a->getClassName(), $a->isCollection(), $a->getCollectionKeyType(), $a->getCollectionValueType());
        if (!$this->typesAreEqual($a, $b) && $this->typesAreEqual($notNullableA, $b)) {
            return true;
        }
        // a is iterable and b is array
        $arrayA = new Type(Type::BUILTIN_TYPE_ARRAY, $a->isNullable(), $a->getClassName(), $a->isCollection(), $a->getCollectionKeyType(), $a->getCollectionValueType());
        if (Type::BUILTIN_TYPE_ITERABLE === $a->getBuiltinType() && $this->typesAreEqual($arrayA, $b)) {
            return true;
        }
        // a is parent class of b
        $aWithBClass = new Type($a->getBuiltinType(), $a->isNullable(), $b->getClassName(), $a->isCollection(), $a->getCollectionKeyType(), $a->getCollectionValueType());
        if ($this->typesAreEqual($aWithBClass, $b) && is_subclass_of((string) $b->getClassName(), (string) $a->getClassName())) {
            return true;
        }
        // a collection value is more generic than b collection value
        $aWithBCollectionValue = new Type($a->getBuiltinType(), $a->isNullable(), $a->getClassName(), $a->isCollection(), $a->getCollectionKeyType(), $b->getCollectionValueType());
        if ($this->typesAreEqual($aWithBCollectionValue, $b)) {
            if ($a->getCollectionValueType() && $b->getCollectionValueType()) {
                return $this->firstTypeIsMoreGeneralThanSecond($a->getCollectionValueType(), $b->getCollectionValueType());
            }
        }

        return false;
    }

    private function nullableTypesAreEqual(?Type $a, ?Type $b): bool
    {
        if (null === $a && null === $b) {
            return true;
        }

        if (null === $a || null == $b) {
            return false;
        }

        return $this->typesAreEqual($a, $b);
    }
}
