<?php

declare(strict_types=1);

namespace Abryb\ParameterInfo\Util;

use Abryb\ParameterInfo\Type;

/**
 * @author Błażej Rybarkiewicz <b.rybarkiewicz@gmail.com>
 *
 * @internal
 */
class TypeCollection
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
    public function __construct(array $types = [], TypeComparator $typeComparator = null)
    {
        $this->types          = $types;
        $this->typeComparator = $typeComparator ?? new TypeComparator();
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
                return false;
            }
        }

        return true;
    }

    public function add(Type $type): self
    {
        $this->types[] = $type;

        return $this;
    }
}
