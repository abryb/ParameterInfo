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
     * @param \ReflectionFunction $function
     * @return ParameterInfo[]
     */
    public function getFunctionParameters(\ReflectionFunction $function) : array;

    /**
     * @param \ReflectionMethod $method
     * @return ParameterInfo[]
     */
    public function getMethodParameters(\ReflectionMethod $method) : array;
}
