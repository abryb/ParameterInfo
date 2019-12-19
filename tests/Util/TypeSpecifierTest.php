<?php

declare(strict_types=1);

namespace Abryb\ParameterInfo\Tests\Util;

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
        $string                   = new Type(Type::BUILTIN_TYPE_STRING);
        $iterable                 = new Type(Type::BUILTIN_TYPE_ITERABLE);
        $array                    = new Type(Type::BUILTIN_TYPE_ARRAY);
        $iterableCollection       = new Type(Type::BUILTIN_TYPE_ITERABLE, false, null, true);
        $arrayCollection          = new Type(Type::BUILTIN_TYPE_ARRAY, false, null, true);
        $arrayCollectionIntString = new Type(Type::BUILTIN_TYPE_ARRAY, false, null, true, new Type(Type::BUILTIN_TYPE_INT), new Type(Type::BUILTIN_TYPE_STRING));
        $nullableArray            = new Type(Type::BUILTIN_TYPE_ARRAY, true);
        $object                   = new Type(Type::BUILTIN_TYPE_OBJECT);
        $objectDateTimeInterface  = new Type(Type::BUILTIN_TYPE_OBJECT, false, \DateTimeInterface::class);
        $objectDateTime           = new Type(Type::BUILTIN_TYPE_OBJECT, false, \DateTime::class);

        return [
            //            [null, null, null],
            //            [null, $object, $object],
            //            [$object, null, $object],
            //            [$string, $arrayCollectionIntString, $string],
            //            [$iterable, $array, $iterable],
            //            [$array, $iterable, $array],
            [$array, $iterableCollection, $arrayCollection],
            [$arrayCollection, $arrayCollectionIntString, $arrayCollectionIntString],
            [$nullableArray, $array, $array],
            [$array, $nullableArray, $array],
            [$object, $objectDateTimeInterface, $objectDateTimeInterface],
            [$objectDateTimeInterface, $objectDateTime, $objectDateTime],
        ];
    }
}
