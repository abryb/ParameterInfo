<?php

declare(strict_types=1);

namespace Abryb\ParameterInfo\Tests\Util;

use Abryb\ParameterInfo\Tests\Helper\TypeFixtures;
use Abryb\ParameterInfo\Type;
use Abryb\ParameterInfo\Util\TypeComparator;
use PHPUnit\Framework\TestCase;

/**
 * @author Błażej Rybarkiewicz <b.rybarkiewicz@gmail.com>
 *
 * @covers \Abryb\ParameterInfo\Util\TypeComparator
 *
 * @internal
 */
class TypeComparatorTest extends TestCase
{
    private $comparator;

    protected function setUp(): void
    {
        $this->comparator = new TypeComparator();
    }

    /**
     * @dataProvider canResolveMoreGeneralTypeDataProvider
     */
    public function testCanResolveMoreGeneralType(Type $a, Type $b, bool $expected)
    {
        $this->assertSame($expected, $this->comparator->firstTypeIsMoreGeneralThanSecond($a, $b));
    }

    public function canResolveMoreGeneralTypeDataProvider()
    {
        return [
            [TypeFixtures::string(), TypeFixtures::string(), false],
            [TypeFixtures::string(), TypeFixtures::nullableString(), false],
            [TypeFixtures::iterable(), TypeFixtures::array(), true],
            [TypeFixtures::nullableString(), TypeFixtures::string(), true],
            [TypeFixtures::dateTime(), TypeFixtures::dateTime(), false],
            [TypeFixtures::dateTime(), TypeFixtures::dateTimeInterface(), false],
            [TypeFixtures::dateTimeInterface(), TypeFixtures::dateTime(), true],
            [TypeFixtures::arrayOfDateTimeInterface(), TypeFixtures::arrayOfDateTime(), true],
        ];
    }
}
