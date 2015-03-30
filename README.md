# Comparable

[![Author](http://img.shields.io/badge/author-@fschmengler-blue.svg?style=flat-square)](https://twitter.com/fschmengler)
[![Latest Version](https://img.shields.io/github/release/sgh-it/comparable.svg?style=flat-square)](https://github.com/schmengler/Comparator-Tools/releases)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/schmengler/Comparator-Tools/master.svg?style=flat-square)](https://travis-ci.org/schmengler/Comparator-Tools)

This package, formerly known as Comparator Tools, provides sorting of objects
that have a Comparable interface and other useful functions with comparison of
objects. With these tools the `Comparable` and `Comparator` interfaces can be
used as known from Java.

## Requirements

The package requires PHP 5.4 or later. The `2.x` branch requires PHP 5.6 or later.

## Install

Via Composer

``` bash
$ composer require sgh/comparable
```

## Usage

To give your classes the comparable functionality, implement the Comparable
interface:

    use SGH\Comparable\Comparable;

    class Foo implements Comparable
    {
        public function compareTo($object)
        {
            // if $this less than $object,    return -1
            // if $this equals $object,       return 0
            // if $this greater than $object, return 1
        }
    }
    
The compareTo method will be called with another instance of Foo as parameter
and must return a negative integer value if ($this < $object) applies and a
positive integer value if ($this > $object) applies, 0 otherwise (the objects
are considered equal). Note that non-integer values will be cast to (int), so
that `0.5` will be treated as `0`.

To sort or compare objects with the Comparable interface, you can use the
methods in `SortFunctions` and `SetFunctions`.

### Sorting

    use SGH\Comparable\SortFunctions;

    SortFunctions::sort($arrayOfFoo);
    SortFunctions::asort($arrayOfFoo);
    SortFunctions::rsort($arrayOfFoo);
    SortFunctions::arsort($arrayOfFoo);
    SortFunctions::multisort($arrayOfFoo, $arbitraryArray, ...);

The first four methods work analogous to the respective core functions `sort`,
`asort`, `rsort` and `arsort`. `multisort` works like `array_multisort` in the
"sort multiple arrays" mode, i.e. the first passed array is sorted with the
Comparable interface, the others are re-ordered in the same way as the first.

### Comparing

    use SGH\Comparable\SetFunctions;
    
    $diff = SetFunctions::diff($arrayOfFoo1, $arrayOfFoo2, ...);
    $diff = SetFunctions::diff_assoc($arrayOfFoo1, $arrayOfFoo2, ...);
    $intersect = SetFunctions::intersect($arrayOfFoo1, $arrayOfFoo2, ...);
    $intersect = SetFunctions::intersect_assoc($arrayOfFoo1, $arrayOfFoo2, ...);
    $unique = SetFunctions::unique($arrayOfFoo);

The methods work analogous to the respective core functions `array_diff`,
`array_diff_assoc`, `array_intersect`, `array_intersect_assoc` and
`array_unique`. They treat objects `$a` and `$b` as equal if and only if
`$a->compareTo($b) == 0`.


### Comparators

It is also possible to implement the comparison in comparator classes to keep
it separated from the objects to compare. This way comparison can be implemented
for any values:

    use SGH\Comparable\Comparator;

    class FooComparator implements Comparator
    {
        public function compare($object1, $object2)
        {
            // if $object1 less than $object2,    return -1
            // if $object1 equals $object2,       return 0
            // if $object1 greater than $object2, return 1
        }
    }

The compare method is defined just like the compareTo method but both objects are
passed as parameters.

To use a comparator, pass it as last argument to any method of `SetFunctions`
and `SortFunctions`:

    use SGH\Comparable\SortFunctions;
    use SGH\Comparable\SetFunctions;

    SortFunctions::sort($arrayOfFoo, new FooComparator);
    SortFunctions::asort($arrayOfFoo, new FooComparator);
    SortFunctions::rsort($arrayOfFoo, new FooComparator);
    SortFunctions::arsort($arrayOfFoo, new FooComparator);
    SortFunctions::multisort($arrayOfFoo, $arbitraryArray, ..., new FooComparator);
    
    $diff = SetFunctions::diff($arrayOfFoo1, $arrayOfFoo2, ..., new FooComparator);
    $diff = SetFunctions::diff_assoc($arrayOfFoo1, $arrayOfFoo2, ..., new FooComparator);
    $intersect = SetFunctions::intersect($arrayOfFoo1, $arrayOfFoo2, ..., new FooComparator);
    $intersect = SetFunctions::intersect_assoc($arrayOfFoo1, $arrayOfFoo2, ..., new FooComparator);
    $unique = SetFunctions::unique($arrayOfFoo, new FooComparator);

#### The ObjectComparator

The package comes with an `ObjectComparator` that compares equality of objects
(i.e. if two variables contain the same instance). It provides no useful sort
order but can be used with the methods in `SetFunctions` (the core functions 
`array_diff` etc. cannot compare objects, they try to cast them to string for
comparison).

    use SGH\Comparable\SetFunctions;
    use SGH\Comparable\Comparator\ObjectComparator;

    $diff = SetFunctions::diff($arrayOfObjects1, $arrayOfObjects2, new ObjectComparator);
	// .. and so on

The following shortcut methods exist:

    SetFunctions::objectsDiff($arrayOfObjects1, $arrayOfObjects2);
    SetFunctions::objectsIntersect($arrayOfObjects1, $arrayOfObjects2);
    SetFunctions::objectsUnique($arrayOfObjects);

### SortedIterator

You can sort iterators as well. Due to the nature of iterators, this means
essentially that they get iterated over once, and you get an ArrayIterator
with all resulting items, sorted. To sort an iterator, decorate it with the
`SortedIterator` like this:

    use SGH\Comparable\SortFunctions;
    
    $sortedIterator = SortFunctions::sortedIterator($iterator);

### Exceptions

The default comparator throws a `ComparatorException` if one of the objects
does not implement the `Comparable` interface.

You are encouraged to throw a `ComparatorException` in your `compare()` or
`compareTo()` implementations if the objects are not comparable to each other.
In most cases you should do it if the objects are not of expected type.

## Testing

``` bash
$ phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email fschmengler@sgh-it.eu instead of using the issue tracker.

## Credits

- Fabian Schmengler(https://github.com/schmengler)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.