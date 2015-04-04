<?php
namespace SGH\Comparable\Comparator;

use SGH\Comparable\Comparator;
use SGH\Comparable\ComparatorException;

/**
 * Comparator for numerical comparison with &lt; and &gt;. Useful together with complex comparators
 * that need another comparator, like SGH\Comparable\Arrays\Comparator\KeyComparator.
 *
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2015 SGH informationstechnologie UG
 * @license MIT
 * @link http://opensource.org/licenses/mit-license.php
 * @package Comparable
 * @since 1.1.0
 */
class NumericComparator implements Comparator
{
    /**
     * (non-PHPdoc)
     * 
     * @see \SGH\Comparable\Comparator::compare()
     */
    public function compare($object1, $object2)
    {
        if (! is_scalar($object1) && ! is_null($object1)) {
            throw new ComparatorException('$object1 (type: ' . gettype($object1) . ') is not a primitive numeric type.');
        }
        if (! is_scalar($object2) && ! is_null($object2)) {
            throw new ComparatorException('$object2 (type: ' . gettype($object2) . ') is not a primitive numeric type.');
        }
        if (1 * $object1 < 1 * $object2) {
            return - 1;
        } elseif (1 * $object1 > 1 * $object2) {
            return 1;
        } else {
            return 0;
        }
    }
    /**
     * Returns a callback object that can be used for core functions that take a callback parameter
     *
     * @return \SGH\Comparable\Comparator\InvokableComparator
     */
    public static function callback()
    {
        return new InvokableComparator(new static);
    }
}