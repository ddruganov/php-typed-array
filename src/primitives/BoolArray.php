<?php

namespace ddruganov\TypedArray\primitives;

use ddruganov\TypedArray\TypedArray;
use ddruganov\TypedArray\TypeDescription;

final class BoolArray extends TypedArray
{
    public function __construct()
    {
        parent::__construct(TypeDescription::of(TypeDescription::BOOL));
    }

    public function offsetGet(mixed $offset): ?bool
    {
        return parent::offsetGet($offset);
    }
}
