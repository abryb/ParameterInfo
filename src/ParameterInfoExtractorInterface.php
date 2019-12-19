<?php

declare(strict_types=1);

namespace Abryb\ParameterInfo;

/**
 * @author Błażej Rybarkiewicz <b.rybarkiewicz@gmail.com>
 */
interface ParameterInfoExtractorInterface
{
    public function getInfo(\ReflectionParameter $parameter): ParameterInfo;
}
