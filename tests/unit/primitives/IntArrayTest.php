<?php

namespace tests\unit\primitives;

use Codeception\Test\Unit;
use ddruganov\TypedArray\primitives\IntArray;
use InvalidArgumentException;
use tests\helpers\DummyClass;

final class IntArrayTest extends Unit
{
    public function testAddValidValue()
    {
        $array = new IntArray();
        $array[] = PHP_INT_MAX;

        $this->assertNotEmpty($array);
        $this->assertCount(1, $array);
        $this->assertTrue($array[0] === PHP_INT_MAX);
    }

    public function testAddNull()
    {
        $array = new IntArray();
        $array[] = null;

        $this->assertNotEmpty($array);
        $this->assertCount(1, $array);
        $this->assertTrue($array[0] === null);
    }

    public function testAddInvalidValue()
    {
        $invalidValues = [
            true,
            pi(),
            PHP_OS,
            new DummyClass()
        ];

        foreach ($invalidValues as $invalidValue) {
            $exceptionCaught = false;
            try {
                $array = new IntArray();
                $array[] = $invalidValue;
            } catch (InvalidArgumentException) {
                $exceptionCaught = true;
            }
            $this->assertTrue($exceptionCaught);
        }
    }
}
