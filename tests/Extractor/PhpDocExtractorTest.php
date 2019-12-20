<?php

declare(strict_types=1);

namespace Abryb\ParameterInfo\Tests\Extractor;

use Abryb\ParameterInfo\Extractor\PhpDocExtractor;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @covers \Abryb\ParameterInfo\Extractor\PhpDocExtractor
 */
class PhpDocExtractorTest extends TestCase
{
    private $extractor;

    protected function setUp(): void
    {
        $this->extractor = new PhpDocExtractor();
    }

    public function canExtractTypesDataProvider()
    {
        $fixtures = new PhpDocExtractorFixtures();
        $ref      = new \ReflectionClass(PhpDocExtractorFixtures::class);
        foreach ($ref->getMethods(\ReflectionMethod::IS_PUBLIC) as $refMethod) {
            yield [$refMethod->getParameters()[0], $refMethod->invoke($fixtures, [null])];
        }
    }

    /**
     * @throws \ReflectionException
     * @dataProvider canExtractTypesDataProvider
     */
    public function testCanExtractTypes(\ReflectionParameter $parameter, array $expected)
    {
        $types = $this->extractor->getTypes($parameter);

        $this->assertEquals($expected, $types);
    }

    public function testCanGetDescription()
    {
        /**
         * @param array $parameter description
         */
        $testFunction = function (array $parameter) {
        };

        $refMethod = new \ReflectionFunction($testFunction);

        $description = $this->extractor->getDescription($refMethod->getParameters()[0]);

        $this->assertEquals('description', $description);
    }
}
