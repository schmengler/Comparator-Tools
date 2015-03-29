<?php
namespace SGH\Comparable;

use SGH\Comparable\Tool\SetTool;
use SGH\Comparable\Comparator\ObjectComparator;

/**
 * Set functions that compare multiple arrays of Comparables
 *
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2015 SGH informationstechnologie UG
 * @license MIT
 * @link http://opensource.org/licenses/mit-license.php
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
        return self::callWithComparator('diff', func_get_args());
    }
    public static function intersect()
    {
        return self::callWithComparator('intersect', func_get_args());
    }
    public static function diff_assoc()
    {
        return self::callWithComparator('diffAssoc', func_get_args());
    }
    public static function intersect_assoc()
    {
        return self::callWithComparator('intersectAssoc', func_get_args());
    }
    public static function unique(array $array, Comparator $comparator = null)
    {
        return (new SetTool)->setComparator($comparator)->unique($array);
    }
	/**
     * @param function
     * @param args
     */
    private static function callWithComparator($function, $args)
    {
        $comparator = null;
        if (end($args) instanceof Comparator) {
            $comparator = array_pop($args);
        }
        $callback = [ (new SetTool())->setComparator($comparator), $function ];
        return call_user_func_array($callback, $args);
    }
}