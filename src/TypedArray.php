<?php

namespace ddruganov\TypedArray;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use TypeError;

class TypedArray implements ArrayAccess, IteratorAggregate, Countable
{
    private TypeDescription $typeDescription;
    private array $values = [];

    public function __construct(TypeDescription $typeDescription)
    {
        $this->typeDescription = $typeDescription;
    }

    public static function of(TypeDescription $typeDescription)
    {
        return new self($typeDescription);
    }

    public function getTypeDescription()
    {
        return $this->typeDescription;
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->values[$offset]);
    }

    public function offsetGet(mixed $offset)
    {
        return $this->values[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!$this->typeDescription->check($value)) {
            $actualType = is_object($value) ? get_class($value) : gettype($value);
            throw new TypeError("Cannot insert $actualType into an array of {$this->typeDescription->getTypeName()}");
        }

        if ($offset === null) {
            $this->values[] = $value;
        } else {
            $this->values[$offset] = $value;
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->values[$offset]);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->values);
    }

    public function count(): int
    {
        return count($this->values);
    }

    public function toPlainArray(): array
    {
        return $this->values;
    }

    public static function from(TypedArray ...$typedArrays)
    {
        $reference = $typedArrays[0];
        $new = new static($reference->getTypeDescription());
        foreach ($typedArrays as $typedArray) {
            foreach ($typedArray as $value) {
                $new[] = $value;
            }
        }

        return $new;
    }
}
