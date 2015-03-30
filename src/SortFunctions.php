<?php
namespace SGH\Comparable;

use SGH\Comparable\Tool\SortTool;
use SGH\Comparable\Tool\SortedIterator;

/**
 * Sort functions for arrays of Comparables
 *
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2015 SGH informationstechnologie UG
 * @license MIT
 * @link http://opensource.org/licenses/mit-license.php
 * @package Comparable
 * @since 1.0.0
 */
class SortFunctions
{
    /**
     * Sort an array based on the Comparator. It will assign new keys to the array.
     *
     * @param array $array
     *            Array that will be sorted
     * @param Comparator $comparator
     *            Comparator to be used for comparison. By default, the ComparableComparator will be used.
     * @return void
     */
    public static function sort(array &$array, Comparator $comparator = null)
    {
        (new SortTool())->setComparator($comparator)
            ->sort($array);
    }

    /**
     * Sort an array of objects, maintaining array keys, based on the Comparator
     *
     * @param array $array
     *            Array that will be sorted
     * @param Comparator $comparator
     *            Comparator to be used for comparison. By default, the ComparableComparator will be used.
     * @return void
     */
    public static function asort(array &$array, Comparator $comparator = null)
    {
        (new SortTool())->setComparator($comparator)
            ->sortAssociative($array);
    }

    /**
     * Sort an array in reverse order based on the Comparator. It will assign new keys to the array.
     *
     * @param array $array
     *            Array that will be sorted
     * @param Comparator $comparator
     *            Comparator to be used for comparison. By default, the ComparableComparator will be used.
     * @return void
     */
    public static function rsort(array &$array, Comparator $comparator = null)
    {
        (new SortTool())->setComparator($comparator)->reverse()->sort($array);
    }

    /**
     * Sort an array of objects in reverse order, maintaining array keys, based on the Comparator
     *
     * @param array $array
     *            Array that will be sorted
     * @param Comparator $comparator
     *            Comparator to be used for comparison. By default, the ComparableComparator will be used.
     * @return void
     */
    public static function arsort(array &$array, Comparator $comparator = null)
    {
        (new SortTool())->setComparator($comparator)->reverse()->sortAssociative($array);
    }

    /**
     * Sort multiple arrays of objects based on the Comparator
     *
     * Works like array_multisort in "sort multiple arrays" mode: first array is sorted by $this->comparator,
     * additional arrays by the first array.
     * NOTE: The arrays must be provided as an array of references. Example:
     * <code>
     * $array1 = array(new ComparableObject(3), new ComparableObject(1), new ComparableObject(2));
     * $array2 = array('object three', 'object one', 'object two');
     * $array3 = array('foo', 'bar', 'baz');
     * SortFunctions::multisort(array(&$array1, &$array2, &$array3));
     * </code>
     *
     * @param array $arrays
     *            Array of references to the arrays that should be sorted by the first of them
     * @param Comparator $comparator
     *            Comparator to be used for comparison. By default, the ComparableComparator will be used.
     * @return void
     * @throws \InvalidArgumentException if $arrays is not an array of arrays with same sizes
     */
    public static function multisort(array &$arrays, Comparator $comparator = null)
    {
        (new SortTool())->setComparator($comparator)->multisort($arrays);
    }

    /**
     * Converts an iterator to a sorted iterator, based on a given Comparator.
     * Uses ComparableComparator by default.
     *
     * @param \Traversable $iterator            
     *            The original iterator
     * @param Comparator $comparator
     *            Comparator to be used for comparison. By default, the ComparableComparator will be used.
     * @param bool $cloneItems         
     *            clones the elements of $iterator, this is necessary for Iterators that return the same instance
     *            in different states like the evil DirectoryIterator.
     * @return \SGH\Comparable\Tool\SortedIterator
     */
    public static function sortedIterator(\Traversable $iterator, Comparator $comparator = null, $cloneItems = false)
    {
        return (new SortedIterator($iterator, $cloneItems))->setComparator($comparator);
    }
}
