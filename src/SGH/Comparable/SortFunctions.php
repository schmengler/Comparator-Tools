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
    public static function sort(array &$array)
    {
        (new SortTool())->sort($array);
    }

    public static function asort(array &$array)
    {
        (new SortTool())->sortAssociative($array);
    }

    public static function rsort(array &$array)
    {
        (new SortTool())->setReverse(true)->sort($array);
    }

    public static function arsort(array &$array)
    {
        (new SortTool())->setReverse(true)->sortAssociative($array);
    }

    public static function multisort(array &$arrays )
    {
        (new SortTool())->multisort($arrays);
    }
}
