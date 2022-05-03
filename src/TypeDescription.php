<?php

namespace ddruganov\TypedArray;

use InvalidArgumentException;

final class TypeDescription
{
    public const STRING = 'string';
    public const INT = 'integer';
    public const FLOAT = 'float';
    private const DOUBLE = 'double';
    public const BOOL = 'boolean';

    private const PRIMITIVES =  [
        self::STRING => self::STRING,
        self::INT => self::INT,
        self::FLOAT => self::FLOAT,
        self::DOUBLE => self::FLOAT,
        self::BOOL => self::BOOL
    ];

    public function __construct(
        private string $typeName,
        private bool $allowsNull = true
    ) {
        if (!$this->isTypePrimitive($typeName) && !class_exists($typeName)) {
            throw new InvalidArgumentException("$typeName is neither a primitive nor a valid class name");
        }
    }

    public static function of(string $typeName, bool $allowsNull = true)
    {
        return new self($typeName, $allowsNull);
    }

    public function getTypeName()
    {
        return $this->typeName;
    }

    public function check(mixed $value)
    {
        if ($this->allowsNull && ($value === null)) {
            return true;
        }

        if (is_object($value)) {
            return is_a($value, $this->typeName);
        }

        $valueTypeName = gettype($value);
        if ($this->isTypePrimitive($valueTypeName)) {
            return self::PRIMITIVES[$valueTypeName] === $this->typeName;
        }

        return false;
    }

    private function isTypePrimitive(string $typeName): bool
    {
        return isset(self::PRIMITIVES[$typeName]);
    }
}
