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
    public function typesAreEqual(?Type $a, ?Type $b): bool
    {
        if (null === $a && null === $b) {
            return true;
        }

        if (null === $a || null == $b) {
            return false;
        }

        return
            $a->getBuiltinType() === $b->getBuiltinType()
            && $a->isNullable() === $b->isNullable()
            && $a->getClassName() === $b->getClassName()
            && $a->isCollection() === $b->isCollection()
            && $this->typesAreEqual($a->getCollectionKeyType(), $b->getCollectionKeyType())
            && $this->typesAreEqual($a->getCollectionValueType(), $b->getCollectionValueType());
    }
}
