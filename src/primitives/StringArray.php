<?php

namespace ddruganov\TypedArray\primitives;

use ddruganov\TypedArray\TypedArray;
use ddruganov\TypedArray\TypeDescription;

final class StringArray extends TypedArray
{
    public function __construct()
    {
        parent::__construct(TypeDescription::of(TypeDescription::STRING));
    }

    public function offsetGet(mixed $offset): ?string
    {
        return parent::offsetGet($offset);
    }
}
