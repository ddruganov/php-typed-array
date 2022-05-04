<?php

namespace tests\unit\primitives;

use Codeception\Test\Unit;
use ddruganov\TypedArray\primitives\StringArray;
use TypeError;
use tests\helpers\DummyClass;

final class StringArrayTest extends Unit
{
    public function testAddValidValue()
    {
        $array = new StringArray();
        $array[] = PHP_OS;

        $this->assertNotEmpty($array);
        $this->assertCount(1, $array);
        $this->assertTrue($array[0] === PHP_OS);
    }

    public function testAddNull()
    {
        $array = new StringArray();
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
            PHP_INT_MAX,
            new DummyClass()
        ];

        foreach ($invalidValues as $invalidValue) {
            $exceptionCaught = false;
            try {
                $array = new StringArray();
                $array[] = $invalidValue;
            } catch (TypeError) {
                $exceptionCaught = true;
            }
            $this->assertTrue($exceptionCaught);
        }
    }
}
