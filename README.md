# PhpTypedArray

Typed array support for php

## Installation

`composer require ddruganov/typed-array`

## How-to

Use `TypedArray` to create a container of a certain type:

```php
final class SomeClass
{
    public TypedArray $typedArray;

    public function __construct()
    {
        $this->typedArray = TypedArray::of(TypeDescription::of(TypeDescription::INT));
    }
}
```

Unfortunately, something like this is entirely possible:

```php
final class SomeClass
{
    public TypedArray $typedArray;

    public function __construct()
    {
        $this->typedArray = TypedArray::of(TypeDescription::of(TypeDescription::INT));
    }

    public function someMethod()
    {
        $this->typedArray = TypedArray::of(TypeDescription::of(TypeDescription::STRING));
    }
}
```

To counter that, define a class extending the typed array:

```php
final class DummyArray extends TypedArray
{
    public function __construct()
    {
        parent::__construct(new TypeDescription(DummyClass::class));
    }

    public function offsetGet(mixed $offset): DummyClass
    {
        return parent::offsetGet($offset);
    }
}
```

You're good to go :)