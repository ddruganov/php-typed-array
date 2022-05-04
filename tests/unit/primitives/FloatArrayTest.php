<?php

namespace tests\unit\primitives;

use Codeception\Test\Unit;
use ddruganov\TypedArray\primitives\FloatArray;
use TypeError;
use tests\helpers\DummyClass;

final class FloatArrayTest extends Unit
{
    public function testAddValidValue()
    {
        $array = new FloatArray();
        $array[] = pi();

        $this->assertNotEmpty($array);
        $this->assertCount(1, $array);
        $this->assertTrue($array[0] === pi());
    }

    public function testAddNull()
    {
        $array = new FloatArray();
        $array[] = null;

        $this->assertNotEmpty($array);
        $this->assertCount(1, $array);
        $this->assertTrue($array[0] === null);
    }

    public function testAddInvalidValue()
    {
        $invalidValues = [
            true,
            PHP_INT_MAX,
            PHP_OS,
            new DummyClass()
        ];

        foreach ($invalidValues as $invalidValue) {
            $exceptionCaught = false;
            try {
                $array = new FloatArray();
                $array[] = $invalidValue;
            } catch (TypeError) {
                $exceptionCaught = true;
            }
            $this->assertTrue($exceptionCaught);
        }
    }
}
