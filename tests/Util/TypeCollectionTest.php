<?php

declare(strict_types=1);

namespace Abryb\ParameterInfo\Tests\Util;

use Abryb\ParameterInfo\Tests\Helper\TypeFixtures;
use Abryb\ParameterInfo\Util\TypeCollection;
use PHPUnit\Framework\TestCase;

/**
 * @author Błażej Rybarkiewicz <b.rybarkiewicz@gmail.com>
 *
 * @covers \Abryb\ParameterInfo\Util\TypeCollection
 *
 * @internal
 */
class TypeCollectionTest extends TestCase
{
    public function testContainsReturnTrueIfContainsEqualTypeAndFalseOtherwise()
    {
        $type = TypeFixtures::arrayOfStrings();

        $type2 = TypeFixtures::arrayOfFloats();

        $collection = new TypeCollection([$type]);

        $this->assertTrue($collection->contains($type));
        $this->assertTrue($collection->contains(clone $type));

        $this->assertFalse($collection->contains($type2));
    }

    public function testGeneralizeReturnsMoreGeneralType()
    {
        $moreGeneral  = TypeFixtures::arrayOfDateTimeInterface();
        $moreSpecific = TypeFixtures::arrayOfDateTime();

        $collection = new TypeCollection([$moreGeneral, $moreSpecific]);

        $this->assertEquals([$moreGeneral], $collection->generalize()->toArray());
    }

    public function testUnique()
    {
        $t1 = TypeFixtures::string();
        $t2 = TypeFixtures::string();

        $collection = new TypeCollection([$t1, $t2]);

        $this->assertEquals([$t1], $collection->unique()->toArray());
    }
}
