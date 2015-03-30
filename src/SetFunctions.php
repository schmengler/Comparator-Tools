<?php
namespace SGH\Comparable;

use SGH\Comparable\Tool\SetTool;
use SGH\Comparable\Comparator\ObjectComparator;

/**
 * Set functions that compare multiple arrays using a Comparator
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
    /**
     * Computes the difference of arrays that contain only objects
     * 
     * Returns an array containing all the entries from array1 that are not present in any of the other arrays.
     * Entries are considered equal if they refer to the same object instance.
     * 
     * @param object[] $array1
     * @param object[] $array2
     * @param object[] $...
     * @return object[]
     */
    public static function objectsDiff(array $array1, array $array2)
    {
        $callback = [ (new SetTool())->setComparator(new ObjectComparator), 'diff' ];
        return call_user_func_array($callback, func_get_args());
    }
    /**
     * Computes the intersection of arrays that contain only objects
     * 
     * Returns an array containing all the values of array1 that are present in all the arguments.
     * Note that keys are preserved.
     * Entries are considered equal if they refer to the same object instance.
     * 
     * @param object[] $array1
     * @param object[] $array2
     * @param object[] $...
     * @return object[]
     */
    public static function objectsIntersect(array $array1, array $array2)
    {
        $callback = [ (new SetTool())->setComparator(new ObjectComparator), 'intersect' ];
        return call_user_func_array($callback, func_get_args());
    }
    /**
     * Removes duplicate values from an array that only contains objects
     * 
     * Takes an input array and returns a new array without duplicate values.
     * Entries are considered equal if they refer to the same object instance.
     * 
     * @param object[] $array
     * @return object[]
     */
    public static function objectsUnique(array $array)
    {
        return self::unique($array, new ObjectComparator);
    }
    /**
     * Computes the difference of arrays based on the Comparator.
     *
     * Objects $o1, $o2 are considered equal if $comparator->compare($o1,$o2) returns zero.
     * With the default ComparableComparator, this is the case if $o1->compareTo($o2) returns zero.
     * 
     * Array keys are not compared, but preserved. Duplicates in $array1 are treated the same way
     *
     * @param array $array1
     *            The array to compare from
     * @param array $array2
     *            An array to compare against.
     * @param array $...
     *            (optional) More arrays to compare against.
     * @param Comparator $comparator
     *            (optional) Comparator to be used for comparison. By default, the ComparableComparator will be used.
     * @return array an array containing all the entries from array1 that are not present in any of the other arrays.
     */
    public static function diff($array1, $array2)
    {
        return self::callWithComparator('diff', func_get_args());
    }
    /**
     * Computes the intersection of arrays based on the Comparator.
     *
     * Objects $o1, $o2 are considered equal if $comparator->compare($o1,$o2) returns zero.
     * With the default ComparableComparator, this is the case if $o1->compareTo($o2) returns zero.
     * 
     * Array keys are not compared, but preserved.
     *
     * @param array $array
     *            The array with master values to check.
     * @param array $array2
     *            An array to compare values against.
     * @param array $...
     *            More arrays to compare against.
     * @param Comparator $comparator
     *            (optional) Comparator to be used for comparison. By default, the ComparableComparator will be used.
     * @return array an array containing all of the values in array1 whose values exist in all of the parameters.
     */
    public static function intersect($array1, $array2)
    {
        return self::callWithComparator('intersect', func_get_args());
    }
    /**
     * Computes the difference of arrays based on the Comparator, with additional index check.
     *
     * Objects $o1, $o2 are considered equal if $comparator->compare($o1,$o2) returns zero.
     * With the default ComparableComparator, this is the case if $o1->compareTo($o2) returns zero.
     *
     * Array keys are not compared, but preserved. Duplicates in $array1 are treated the same way
     *
     * @param array $array1
     *            The array to compare from
     * @param array $array2
     *            An array to compare against.
     * @param array $...
     *            More arrays to compare against.
     * @param Comparator $comparator
     *            (optional) Comparator to be used for comparison. By default, the ComparableComparator will be used.
     * @return array an array containing all the entries from array1 that are not present in any of the other arrays. Keys are also taken into account for comparison.
     */
    public static function diff_assoc()
    {
        return self::callWithComparator('diffAssoc', func_get_args());
    }
    /**
     * Computes the intersection of arrays based on the Comparator, with additional index check.
     *
     * Objects $o1, $o2 are considered equal if $comparator->compare($o1,$o2) returns zero.
     * With the default ComparableComparator, this is the case if $o1->compareTo($o2) returns zero.
     *
     * Array keys are not compared, but preserved.
     *
     * @param array $array
     *            The array with master values to check.
     * @param array $array2
     *            An array to compare values against.
     * @param array $...
     *            More arrays to compare against.
     * @param Comparator $comparator
     *            (optional) Comparator to be used for comparison. By default, the ComparableComparator will be used.
     * @return array an array containing all of the values in array1 whose values exist in all of the parameters. Keys are also taken into account for comparison.
     */
    public static function intersect_assoc()
    {
        return self::callWithComparator('intersectAssoc', func_get_args());
    }

    /**
     * Removes duplicate objects from an array based on the Comparator.
     *
     * Objects $o1, $o2 are considered equal if $comparator->compare($o1,$o2) returns zero.
     * With the default ComparableComparator, this is the case if $o1->compareTo($o2) returns zero.
     *
     * The resulting array will be sorted, keys maintained, however for same items it is undefined which one is kept.
     *
     * @param array $array
     *            The input array
     * @param Comparator $comparator
     *            (optional) Comparator to be used for comparison. By default, the ComparableComparator will be used.
     * @return array The filtered array
     */
    public static function unique(array $array, Comparator $comparator = null)
    {
        return (new SetTool())->setComparator($comparator)->unique($array);
    }
	/**
	 * Calls SetTool method $function with arguments $args. If the last element of $args is a Comparator, it will be used for comparison.
	 * 
     * @param string $function
     * @param array $args
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