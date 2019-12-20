<?php

declare(strict_types=1);

namespace Abryb\ParameterInfo\Tests\Helper;

use Abryb\ParameterInfo\Type;

/**
 * @author Błażej Rybarkiewicz <b.rybarkiewicz@gmail.com>
 */
class TypeFixtures
{
    public static function int()
    {
        return new Type(Type::BUILTIN_TYPE_INT);
    }

    public static function string()
    {
        return new Type(Type::BUILTIN_TYPE_STRING);
    }

    public static function nullableString()
    {
        return new Type(Type::BUILTIN_TYPE_STRING, true);
    }

    public static function iterable()
    {
        return new Type(Type::BUILTIN_TYPE_ITERABLE);
    }

    public static function array()
    {
        return new Type(Type::BUILTIN_TYPE_ARRAY);
    }

    public static function iterableCollection()
    {
        return new Type(Type::BUILTIN_TYPE_ITERABLE, false, null, true);
    }

    public static function arrayCollection()
    {
        return new Type(Type::BUILTIN_TYPE_ARRAY, false, null, true);
    }

    public static function arrayOfStrings()
    {
        return new Type(Type::BUILTIN_TYPE_ARRAY, false, null, true, new Type(Type::BUILTIN_TYPE_INT), new Type(Type::BUILTIN_TYPE_STRING));
    }

    public static function arrayOfFloats()
    {
        return new Type(Type::BUILTIN_TYPE_ARRAY, false, null, true, new Type(Type::BUILTIN_TYPE_INT), new Type(Type::BUILTIN_TYPE_FLOAT));
    }

    public static function nullableArray()
    {
        return new Type(Type::BUILTIN_TYPE_ARRAY, true);
    }

    public static function object()
    {
        return new Type(Type::BUILTIN_TYPE_OBJECT);
    }

    public static function nullableObject()
    {
        return new Type(Type::BUILTIN_TYPE_OBJECT, true);
    }

    public static function dateTimeInterface()
    {
        return new Type(Type::BUILTIN_TYPE_OBJECT, false, \DateTimeInterface::class);
    }

    public static function dateTime()
    {
        return new Type(Type::BUILTIN_TYPE_OBJECT, false, \DateTime::class);
    }

    public static function dateInterval()
    {
        return new Type(Type::BUILTIN_TYPE_OBJECT, false, \DateInterval::class);
    }

    public static function iterableOfDateTime()
    {
        return new Type(Type::BUILTIN_TYPE_ITERABLE, false, null, true, new Type(Type::BUILTIN_TYPE_INT), new Type(Type::BUILTIN_TYPE_OBJECT, false, \DateTime::class));
    }

    public static function arrayOfDateTime()
    {
        return new Type(Type::BUILTIN_TYPE_ARRAY, false, null, true, new Type(Type::BUILTIN_TYPE_INT), new Type(Type::BUILTIN_TYPE_OBJECT, false, \DateTime::class));
    }

    public static function arrayOfDateTimeInterface()
    {
        return new Type(Type::BUILTIN_TYPE_ARRAY, false, null, true, new Type(Type::BUILTIN_TYPE_INT), new Type(Type::BUILTIN_TYPE_OBJECT, false, \DateTimeInterface::class));
    }
}
