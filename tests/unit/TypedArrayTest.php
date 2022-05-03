<?php

namespace tests\unit;

use Codeception\Test\Unit;
use ddruganov\TypedArray\TypedArray;
use ddruganov\TypedArray\TypeDescription;
use InvalidArgumentException;
use tests\helpers\DummyClass;

final class TypedArrayTest extends Unit
{
    # class typed

    public function testClassTypedAddValidValue()
    {
        $this->setName('Typed with class: add valid value');

        $array = $this->getClassTypedArray();
        $array[] = new DummyClass();

        $this->assertNotEmpty($array);
        $this->assertCount(1, $array);
        $this->assertTrue(get_class($array[0]) === DummyClass::class);
    }

    public function testClassTypedAddNullWhenNullIsAllowed()
    {
        $this->setName('Typed with class: add null when null is allowed');

        $array = $this->getClassTypedArray(allowsNull: true);
        $array[] = null;

        $this->assertNotEmpty($array);
        $this->assertCount(1, $array);
        $this->assertTrue($array[0] === null);
    }

    public function testClassTypedAddNullWhenNullIsNotAllowed()
    {
        $this->setName('Typed with class: add null when null is not allowed');

        $exceptionCaught = false;
        try {
            $array = $this->getClassTypedArray(allowsNull: false);
            $array[] = null;
        } catch (InvalidArgumentException) {
            $exceptionCaught = true;
        }
        $this->assertTrue($exceptionCaught);
    }

    public function testClassTypedAddInvalidValue()
    {
        $this->setName('Typed with class: add invalid value');

        $invalidValues = [
            PHP_OS,
            PHP_INT_MAX,
            pi(),
            [],
            true
        ];

        foreach ($invalidValues as $invalidValue) {
            $exceptionCaught = false;
            try {
                $array = $this->getClassTypedArray();
                $array[] = $invalidValue;
            } catch (InvalidArgumentException) {
                $exceptionCaught = true;
            }
            $this->assertTrue($exceptionCaught);
        }
    }

    private function getClassTypedArray(bool $allowsNull = true)
    {
        return new class($allowsNull) extends TypedArray
        {
            public function __construct(bool $allowsNull)
            {
                parent::__construct(new TypeDescription(DummyClass::class, $allowsNull));
            }

            public function offsetGet(mixed $offset): ?DummyClass
            {
                return parent::offsetGet($offset);
            }
        };
    }

    # primitive typed

    public function testPrimitiveTypedAddValidValue()
    {
        $this->setName('Typed with primitives: add valid value');

        $array = $this->getPrimitiveTypedArray();
        $array[] = PHP_INT_MAX;

        $this->assertNotEmpty($array);
        $this->assertCount(1, $array);
        $this->assertTrue(gettype($array[0]) === gettype(PHP_INT_MAX));
    }

    public function testPrimitiveTypedAddNull()
    {
        $this->setName('Typed with primitives: add null');

        $array = $this->getPrimitiveTypedArray();
        $array[] = null;

        $this->assertNotEmpty($array);
        $this->assertCount(1, $array);
        $this->assertTrue($array[0] === null);
    }

    public function testPrimitiveTypedAddNullWhenNullIsAllowed()
    {
        $this->setName('Typed with primitives: add null when null is allowed');

        $array = $this->getPrimitiveTypedArray(allowsNull: true);
        $array[] = null;

        $this->assertNotEmpty($array);
        $this->assertCount(1, $array);
        $this->assertTrue($array[0] === null);
    }

    public function testPrimitiveTypedAddNullWhenNullIsNotAllowed()
    {
        $this->setName('Typed with primitives: add null when null is not allowed');

        $exceptionCaught = false;
        try {
            $array = $this->getPrimitiveTypedArray(allowsNull: false);
            $array[] = null;
        } catch (InvalidArgumentException) {
            $exceptionCaught = true;
        }
        $this->assertTrue($exceptionCaught);
    }

    public function testPrimitiveTypedAddInvalidValue()
    {
        $this->setName('Typed with primitives: add invalid value');

        $invalidValues = [
            PHP_OS,
            new DummyClass(),
            pi(),
            [],
            true
        ];

        foreach ($invalidValues as $invalidValue) {
            $exceptionCaught = false;
            try {
                $array = $this->getPrimitiveTypedArray();
                $array[] = $invalidValue;
            } catch (InvalidArgumentException) {
                $exceptionCaught = true;
            }
            $this->assertTrue($exceptionCaught);
        }
    }

    private function getPrimitiveTypedArray(bool $allowsNull = true)
    {
        return new class($allowsNull) extends TypedArray
        {
            public function __construct(bool $allowsNull)
            {
                parent::__construct(new TypeDescription(TypeDescription::INT, $allowsNull));
            }

            public function offsetGet(mixed $offset): ?int
            {
                return parent::offsetGet($offset);
            }
        };
    }

    # other

    public function testTypedArrayAsClassVariable()
    {
        $object = new class
        {
            public TypedArray $typedArray;

            public function __construct()
            {
                $this->typedArray = TypedArray::of(TypeDescription::of(TypeDescription::INT));
            }
        };

        $this->assertTrue(is_a($object->typedArray, TypedArray::class));
    }
}
