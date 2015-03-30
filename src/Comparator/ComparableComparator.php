<?php
namespace SGH\Comparable\Comparator;

use SGH\Comparable\ComparatorException;
use SGH\Comparable\Comparator;
use SGH\Comparable\Comparable;

/**
 * Comparator used to compare objects that implement the Comparable interface.
 *
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2015 SGH informationstechnologie UG
 * @license MIT
 * @link http://opensource.org/licenses/mit-license.php
 * @package Comparable
 * @since 1.0.0
 */
class ComparableComparator implements Comparator
{

    /**
     * Compare function
     *
     * NOTE: In theory only $object1 has to implement the Comparable interface
     * but as you cannot know in which order the parameters come i.e. from a
     * sorting algorithm, both are checked. Also it is assumed that
     * $object1->compareTo($object2) == (-1) * $object2->compareTo($object1)
     * otherwise ComparatorTools may not work properly
     *
     * @param object $object1            
     * @param object $object2            
     * @return numeric
     */
    public function compare($object1, $object2)
    {
        if (! $object1 instanceof Comparable) {
            throw new ComparatorException('$object1 (type: ' . gettype($object1) . ') does not implement the Comparable interface.');
        }
        if (! $object2 instanceof Comparable) {
            throw new ComparatorException('$object2 (type: ' . gettype($object2) . ') does not implement the Comparable interface.');
		}
		return $object1->compareTo($object2);
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