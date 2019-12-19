<?php

declare(strict_types=1);


namespace Abryb\ParameterInfo\Tests\Extractor;


use Abryb\ParameterInfo\Extractor\ReflectionTypeExtractor;
use Abryb\ParameterInfo\Type;
use PHPUnit\Framework\TestCase;

/**
 * @author Błażej Rybarkiewicz <b.rybarkiewicz@gmail.com>
 */
class ReflectionTypeExtractorTest extends TestCase
{
    private $extractor;



    protected function setUp(): void
    {
        $this->extractor = new ReflectionTypeExtractor();
    }

    /**
     * @dataProvider canGetTypeDataProvider
     */
    public function testCanGetType(\ReflectionParameter $parameter, $expected)
    {
        $this->assertEquals($expected, $this->extractor->getTypes($parameter));
    }

    public function canGetTypeDataProvider()
    {
        $f = function(int $a2, $a3) {

        };
        $ref = new \ReflectionFunction($f);

        return [
            [$ref->getParameters()[0], [new Type(Type::BUILTIN_TYPE_INT)]],
            [$ref->getParameters()[1], []],
        ];
    }
}