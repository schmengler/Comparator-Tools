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

    public static function sort(array &$array, Comparator $comparator = null)
    {
        (new SortTool())->setComparator($comparator)
            ->sort($array);
    }

    public static function asort(array &$array, Comparator $comparator = null)
    {
        (new SortTool())->setComparator($comparator)
            ->sortAssociative($array);
    }

    public static function rsort(array &$array, Comparator $comparator = null)
    {
        (new SortTool())->setComparator($comparator)->reverse()->sort($array);
    }

    public static function arsort(array &$array, Comparator $comparator = null)
    {
        (new SortTool())->setComparator($comparator)->reverse()->sortAssociative($array);
    }

    public static function multisort(array &$arrays, Comparator $comparator = null)
    {
        (new SortTool())->setComparator($comparator)
            ->multisort($arrays);
    }
    
    public static function sortedIterator(\Traversable $iterator, Comparator $comparator = null, $cloneItems = false)
    {
        return (new SortedIterator($iterator, $cloneItems))->setComparator($comparator);
    }
}
