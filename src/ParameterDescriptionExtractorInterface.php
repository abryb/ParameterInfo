<?php

declare(strict_types=1);

namespace Abryb\ParameterInfo;

/**
 * @author Błażej Rybarkiewicz <b.rybarkiewicz@gmail.com>
 */
interface ParameterDescriptionExtractorInterface
{
    public function extractDescription(\ReflectionParameter $parameter): ?string;
}
