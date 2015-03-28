<?php
namespace SGH\Comparable;

use SGH\Comparable\Tool\SetTool;
use SGH\Comparable\Comparator\ObjectComparator;

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

    public static function objectsDiff()
    {
        $callback = [ (new SetTool())->setComparator(new ObjectComparator), 'diff' ];
        return call_user_func_array($callback, func_get_args());
    }
    public static function objectsIntersect()
    {
        $callback = [ (new SetTool())->setComparator(new ObjectComparator), 'intersect' ];
        return call_user_func_array($callback, func_get_args());
    }
    public static function objectsUnique($array)
    {
        return self::unique($array, new ObjectComparator);
    }
    public static function diff()
    {
        $comparator = null;
        $args = func_get_args();
        if (func_get_arg(func_num_args() - 1) instanceof Comparator) {
            $comparator = array_pop($args);
        }
        $callback = [ (new SetTool())->setComparator($comparator), 'diff' ];
        return call_user_func_array($callback, $args);
    }
    public static function intersect()
    {
        $comparator = null;
        $args = func_get_args();
        if (func_get_arg(func_num_args() - 1) instanceof Comparator) {
            $comparator = array_pop($args);
        }
        $callback = [ (new SetTool())->setComparator($comparator), 'intersect' ];
        return call_user_func_array($callback, $args);
    }
    public static function unique(array $array, Comparator $comparator = null)
    {
        return (new SetTool)->setComparator($comparator)->unique($array);
    }
}