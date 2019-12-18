<?php

declare(strict_types=1);

namespace Abryb\ParameterInfo;

/**
 * @author Błażej Rybarkiewicz <b.rybarkiewicz@gmail.com>
 */
interface ParameterTypeExtractorInterface
{
    /**
     * @return Type[]
     */
    public function extractTypes(\ReflectionParameter $parameter): array;
}
