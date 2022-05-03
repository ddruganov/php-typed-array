<?php

namespace ddruganov\TypedArray\primitives;

use ddruganov\TypedArray\TypedArray;
use ddruganov\TypedArray\TypeDescription;

final class IntArray extends TypedArray
{
    public function __construct()
    {
        parent::__construct(TypeDescription::of(TypeDescription::INT));
    }

    public function offsetGet(mixed $offset): ?int
    {
        return parent::offsetGet($offset);
    }
}
