<?php

declare(strict_types=1);

namespace Abryb\ParameterInfo\Tests;

use Abryb\ParameterInfo\ParameterInfoExtractorFactory;
use Abryb\ParameterInfo\Tests\Helper\TypeFixtures;
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
         * @param object|null                      $a0
         * @param \DateTime[]|\DateTime[]|iterable $a1
         * @param \DateTime[]|\DateTimeInterface[] $a2
         * @param int|string                       $a3
         * @param \DateTime                        $a4
         */
        $function = function ($a0, iterable $a1, array $a2, ?int $a3, \DateTimeInterface $a4) {
        };

        $expected = [
            'a0' => [TypeFixtures::nullableObject()],
            'a1' => [TypeFixtures::iterableOfDateTime()],
            'a2' => [TypeFixtures::arrayOfDateTimeInterface()],
            'a3' => [TypeFixtures::int()],
            'a4' => [TypeFixtures::dateTime()],
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
