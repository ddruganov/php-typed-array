<?php

namespace tests\unit\primitives;

use Codeception\Test\Unit;
use ddruganov\TypedArray\primitives\BoolArray;
use TypeError;
use tests\helpers\DummyClass;

final class BoolArrayTest extends Unit
{
    public function testAddValidValue()
    {
        $array = new BoolArray();
        $array[] = true;

        $this->assertNotEmpty($array);
        $this->assertCount(1, $array);
        $this->assertTrue($array[0] === true);
    }

    public function testAddNull()
    {
        $array = new BoolArray();
        $array[] = null;

        $this->assertNotEmpty($array);
        $this->assertCount(1, $array);
        $this->assertTrue($array[0] === null);
    }

    public function testAddInvalidValue()
    {
        $invalidValues = [
            pi(),
            PHP_INT_MAX,
            PHP_OS,
            new DummyClass()
        ];

        foreach ($invalidValues as $invalidValue) {
            $exceptionCaught = false;
            try {
                $array = new BoolArray();
                $array[] = $invalidValue;
            } catch (TypeError) {
                $exceptionCaught = true;
            }
            $this->assertTrue($exceptionCaught);
        }
    }
}
