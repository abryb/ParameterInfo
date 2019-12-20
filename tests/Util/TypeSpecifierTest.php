<?php

declare(strict_types=1);

namespace Abryb\ParameterInfo\Tests\Util;

use Abryb\ParameterInfo\Tests\Helper\TypeFixtures;
use Abryb\ParameterInfo\Type;
use Abryb\ParameterInfo\Util\TypeSpecifier;
use PHPUnit\Framework\TestCase;

/**
 * @author Błażej Rybarkiewicz <b.rybarkiewicz@gmail.com>
 *
 * @internal
 * @covers \Abryb\ParameterInfo\Util\TypeSpecifier
 */
class TypeSpecifierTest extends TestCase
{
    private $specifier;

    protected function setUp(): void
    {
        $this->specifier = new TypeSpecifier();
    }

    /**
     * @dataProvider canSpecifyTypeDataProvider
     */
    public function testCanSpecifyType(?Type $a, ?Type $b, ?Type $expected)
    {
        $this->assertEquals($expected, $this->specifier->specifyType($a, $b));
    }

    public function canSpecifyTypeDataProvider()
    {
        return [
            [null, null, null],
            [null, TypeFixtures::object(), TypeFixtures::object()],
            [TypeFixtures::object(), null, TypeFixtures::object()],
            [TypeFixtures::nullableString(), TypeFixtures::int(), TypeFixtures::nullableString()],
            [TypeFixtures::nullableString(), TypeFixtures::string(), TypeFixtures::string()],
            [TypeFixtures::string(), TypeFixtures::arrayOfStrings(), TypeFixtures::string()],
            [TypeFixtures::iterable(), TypeFixtures::array(), TypeFixtures::iterable()],
            [TypeFixtures::array(), TypeFixtures::iterable(), TypeFixtures::array()],
            [TypeFixtures::array(), TypeFixtures::iterableCollection(), TypeFixtures::arrayCollection()],
            [TypeFixtures::arrayCollection(), TypeFixtures::arrayOfStrings(), TypeFixtures::arrayOfStrings()],
            [TypeFixtures::nullableArray(), TypeFixtures::array(), TypeFixtures::array()],
            [TypeFixtures::array(), TypeFixtures::nullableArray(), TypeFixtures::array()],
            [TypeFixtures::object(), TypeFixtures::dateTimeInterface(), TypeFixtures::dateTimeInterface()],
            [TypeFixtures::dateTimeInterface(), TypeFixtures::dateTime(), TypeFixtures::dateTime()],
            [TypeFixtures::dateTime(), TypeFixtures::dateInterval(), TypeFixtures::dateTime()],
        ];
    }
}
