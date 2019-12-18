<?php

declare(strict_types=1);

namespace Abryb\ParameterInfo\Tests\Extractor;

use Abryb\ParameterInfo\Type;

class PhpDocExtractorFixtures
{
    /**
     * @param string $parameter
     *
     * @return array
     */
    public function phpDocString($parameter)
    {
        return [new Type(Type::BUILTIN_TYPE_STRING)];
    }

    /**
     * @param int[] $parameter
     *
     * @return array
     */
    public function phpDocArrayOfInts($parameter)
    {
        return [$this->createArrayOfBuiltin(Type::BUILTIN_TYPE_INT)];
    }

    /**
     * @param bool|null $parameter
     */
    public function nullableBool($parameter): array
    {
        return [new Type(Type::BUILTIN_TYPE_BOOL, true)];
    }

    /**
     * @param $parameter
     */
    public function noType($parameter): array
    {
        return [];
    }

    public function noTag($parameter): array
    {
        return [];
    }

    /**
     * @param \DateTime[] $parameter
     */
    public function arrayOfClass($parameter): array
    {
        return [
            $this->createArrayOfClass(\DateTime::class),
        ];
    }

    /**
     * @param string
     */
    public function noParamName($parameter): array
    {
        return [new Type(Type::BUILTIN_TYPE_STRING)];
    }

    private function createArrayOfBuiltin(string $type)
    {
        return new Type(
            Type::BUILTIN_TYPE_ARRAY,
            false,
            null,
            true,
            new Type(Type::BUILTIN_TYPE_INT),
            new Type($type)
        );
    }

    private function createArrayOfClass(string $class)
    {
        return new Type(
            Type::BUILTIN_TYPE_ARRAY,
            false,
            null,
            true,
            new Type(Type::BUILTIN_TYPE_INT),
            new Type(
                Type::BUILTIN_TYPE_OBJECT,
                false,
                $class
            )
        );
    }
}
