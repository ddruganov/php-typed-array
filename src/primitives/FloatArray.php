<?php

namespace ddruganov\TypedArray\primitives;

use ddruganov\TypedArray\TypedArray;
use ddruganov\TypedArray\TypeDescription;

final class FloatArray extends TypedArray
{
    public function __construct()
    {
        parent::__construct(TypeDescription::of(TypeDescription::FLOAT));
    }

    public function offsetGet(mixed $offset): ?float
    {
        return parent::offsetGet($offset);
    }
}
