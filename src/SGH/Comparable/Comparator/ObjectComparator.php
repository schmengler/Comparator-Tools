<?php
namespace SGH\Comparable\Comparator;

use SGH\Comparable\Comparator;
use SGH\Comparable\ComparatorException;

/**
 * Comparator that is useful to check if variables refer to the exact same object.
 * It relies on spl_object_hash and therefore provides no useful order for sorting
 * objects.
 *
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2015 SGH informationstechnologie UG
 * @license BSD
 * @link http://creativecommons.org/licenses/BSD/
 * @package Comparable
 * @since 1.0.0
 */
class ObjectComparator implements Comparator
{
    /**
     * (non-PHPdoc)
     * @see \SGH\Comparable\Comparator::compare()
     */
    public function compare($object1, $object2)
    {
        if (! is_object($object1)) {
            throw new ComparatorException('$object1 ("' . $object1 . '") is not an object.');
        }
        if (! is_object($object2)) {
            throw new ComparatorException('$object2 ("' . $object2 . '") is not an object.');
        }
        return strcmp(spl_object_hash($object1), spl_object_hash($object2));
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