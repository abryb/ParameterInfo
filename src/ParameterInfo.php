<?php

declare(strict_types=1);

namespace Abryb\ParameterInfo;

/**
 * @author Błażej Rybarkiewicz <b.rybarkiewicz@gmail.com>
 */
final class ParameterInfo
{
    /**
     * @var \ReflectionParameter
     */
    private $reflectionParameter;

    /**
     * @var Type[]
     */
    private $types;

    /**
     * @var string|null
     */
    private $description;

    /**
     * ParameterInfo constructor.
     *
     * @param Type[] $types
     */
    public function __construct(\ReflectionParameter $reflectionParameter, array $types, ?string $description)
    {
        $this->reflectionParameter = $reflectionParameter;
        $this->types               = $types;
        $this->description         = $description;
    }

    public function getReflection(): \ReflectionParameter
    {
        return $this->reflectionParameter;
    }

    /**
     * @return Type[]
     */
    public function getTypes(): array
    {
        return $this->types;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
