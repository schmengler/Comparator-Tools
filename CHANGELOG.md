# Changelog

All Notable changes to `Comparable` will be documented in this file

## 1.1.1 - 2015-04-06

### Fixed

- removed hard coded version number from composer.json which made installing v1.1.0 via composer impossible.

## 1.1.0 - 2015-04-04

### Added

- `StringComparator` and `NumericComparator`, useful together with complex comparators like in the [sgh/comparable-arrays](https://github.com/schmengler/comparable-arrays) package

## 1.0.0 - 2015-03-30

First stable release with new API and completely refactored, modernized implementation.

### Added

- `diffAssoc` and `intersectAssoc` methods that take keys into account when comparing array items
- `InvokableComparator` decorator that makes any comparator callable, so that it can be used directly in any function that requires a comparison function callback
- Unit tests

### Removed

- procedural interface (in favor of autoloader-friendly static methods in classes `SetFunctions` and `SortFunctions`)
- option to return false and trigger a warning instead of throwing exceptions on error.
- `SplFileInfoComparator` (concrete comparator implementations beyond the default `ComparableComparator` and `ObjectComparator` should be separate packages)

## 0.9.1 - 2010-12-2

### Fixed

- bug in array_multisort

## 0.9.0 - 2010-09-09

Initial release