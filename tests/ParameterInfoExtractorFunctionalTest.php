<?php

declare(strict_types=1);

namespace Abryb\ParameterInfo\Tests;

use Abryb\ParameterInfo\ParameterInfoExtractorFactory;
use Abryb\ParameterInfo\Type;
use PHPUnit\Framework\TestCase;

/**
 * @author Błażej Rybarkiewicz <b.rybarkiewicz@gmail.com>
 *
 * @internal
 * @coversNothing
 */
class ParameterInfoExtractorFunctionalTest extends TestCase
{
    private $extractor;

    protected function setUp(): void
    {
        $this->extractor = ParameterInfoExtractorFactory::create();
    }

    public function functionDataProvider()
    {
        /**
         * @param object|null                               $a0
         * @param \DateTime[]|\DateTimeInterface[]|iterable $a1
         */
        $function = function ($a0, iterable $a1) {
        };

        $expected = [
            'a0' => [new Type(Type::BUILTIN_TYPE_OBJECT, true)],
            'a1' => [
                new Type(
                    Type::BUILTIN_TYPE_ITERABLE,
                    false,
                    null,
                    true,
                    new Type(Type::BUILTIN_TYPE_INT),
                    new Type(Type::BUILTIN_TYPE_OBJECT, false, \DateTime::class)
                ),
                new Type(
                    Type::BUILTIN_TYPE_ITERABLE,
                    false,
                    null,
                    true,
                    new Type(Type::BUILTIN_TYPE_INT),
                    new Type(Type::BUILTIN_TYPE_OBJECT, false, \DateTimeInterface::class)
                ),
            ],
        ];

        $ref = new \ReflectionFunction($function);
        foreach ($ref->getParameters() as $parameter) {
            yield [$parameter, $expected[$parameter->getName()]];
        }
    }

    /**
     * @dataProvider functionDataProvider
     */
    public function testFunctional(\ReflectionParameter $parameter, $expectedTypes)
    {
        $this->assertEquals($expectedTypes, $this->extractor->getParameterInfo($parameter)->getTypes());
    }
}
