<?php

declare(strict_types=1);

namespace Abryb\ParameterInfo;

/**
 * @author Błażej Rybarkiewicz <b.rybarkiewicz@gmail.com>
 */
interface ParameterInfoExtractorInterface
{
    public function getParameterInfo(\ReflectionParameter $parameter): ParameterInfo;

    /**
     * @param \ReflectionFunctionAbstract|\ReflectionFunction|\ReflectionMethod $method
     * @return ParameterInfo[]
     */
    public function getMethodParameters(\ReflectionFunctionAbstract $method) : array;
}
