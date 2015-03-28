<?php
namespace SGH\Comparable;

use SGH\Comparable\Tool\SortTool;

/**
 * Sort functions for arrays of Comparables
 *
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2015 SGH informationstechnologie UG
 * @license BSD
 * @link http://creativecommons.org/licenses/BSD/
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
        (new SortTool())->setComparator($comparator)
            ->setReverse(true)
            ->sort($array);
    }

    public static function arsort(array &$array, Comparator $comparator = null)
    {
        (new SortTool())->setComparator($comparator)
            ->setReverse(true)
            ->sortAssociative($array);
    }

    public static function multisort(array &$arrays, Comparator $comparator = null)
    {
        (new SortTool())->setComparator($comparator)
            ->multisort($arrays);
    }
}
