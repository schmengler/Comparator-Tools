<?php
namespace SGH\Comparable;

use SGH\Comparable\Tool\SetTool;

/**
 * Set functions that compare multiple arrays of Comparables
 *
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2015 SGH informationstechnologie UG
 * @license BSD
 * @link http://creativecommons.org/licenses/BSD/
 * @package Comparable
 * @since 1.0.0
 */
class SetFunctions
{
    public static function withComparator(Comparator $comparator)
    {
        return new SetTool($comparator);
    }
    public static function diff()
    {
        return call_user_func_array(array(new SetTool(), 'diff'), func_get_args());
    }
    public static function intersect()
    {
        return call_user_func_array(array(new SetTool(), 'intersect'), func_get_args());
    }
    public static function unique(array &$array)
    {
        return (new SetTool())->unique($array);
    }
}