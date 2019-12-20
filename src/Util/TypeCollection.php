<?php

declare(strict_types=1);

namespace Abryb\ParameterInfo\Util;

use Abryb\ParameterInfo\Type;

/**
 * @author Błażej Rybarkiewicz <b.rybarkiewicz@gmail.com>
 *
 * @internal
 */
final class TypeCollection
{
    /**
     * @var array|Type[]
     */
    private $types;

    /**
     * @var TypeComparator
     */
    private $typeComparator;

    /**
     * TypeCollection constructor.
     *
     * @param Type[] $types
     */
    public function __construct(array $types = [])
    {
        $this->types          = $types;
        $this->typeComparator = new TypeComparator();
    }

    public function unique(): TypeCollection
    {
        $types = new static([]);
        foreach ($this->types as $type) {
            if (!$types->contains($type)) {
                $types->types[] = $type;
            }
        }

        return $types;
    }

    public function generalize(): TypeCollection
    {
        $result = [];
        foreach ($this->types as $type) {
            if (!$this->containsMoreGenericType($type)) {
                $result[] = $type;
            }
        }

        return new static($result);
    }

    /**
     * @return Type[]
     */
    public function toArray(): array
    {
        return $this->types;
    }

    public function contains(Type $askedType)
    {
        foreach ($this->types as $type) {
            if ($this->typeComparator->typesAreEqual($type, $askedType)) {
                return true;
            }
        }

        return false;
    }

    public function add(Type $type): self
    {
        $this->types[] = $type;

        return $this;
    }

    private function containsMoreGenericType(Type $a)
    {
        foreach ($this->types as $type) {
            if ($this->typeComparator->firstTypeIsMoreGeneralThanSecond($type, $a)) {
                return true;
            }
        }

        return false;
    }
}
