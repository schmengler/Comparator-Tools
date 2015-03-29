<?php
namespace SGH\Comparable\Tool;

use SGH\Comparable\Comparator\ComparableComparator;
use SGH\Comparable\Comparator;

/**
 * Comparator tool with set functions to compare arrays of objects, using Comparators.
 *
 * Provides difference, intersection and removal of duplicates
 *
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2015 SGH informationstechnologie UG
 * @license BSD
 * @link http://creativecommons.org/licenses/BSD/
 * @package Comparable
 * @since 1.0.0
 */
class SetTool
{

    /**
     * The Comparator to be used for comparing
     *
     * @var Comparator
     */
    private $comparator;

    /**
     * Returns the comparator to be used, defaults to
     * ComparableComparator if $comparator has not been specified
     *
     * @return Comparator the Comparator
     */
    public function getComparator()
    {
        if ($this->comparator === null) {
            $this->comparator = new ComparableComparator();
        }
        return $this->comparator;
    }

    /**
     * Sets $comparator
     *
     * @param Comparator $comparator
     *            The Comparator to be used
     * @return $this
     */
    public function setComparator(Comparator $comparator = null)
    {
        $this->comparator = $comparator;
        return $this;
    }

    /**
     * Computes the difference of arrays based on the Comparator.
     *
     * Objects $o1, $o2 are considered equal if $comparator->compare($o1,$o2) returns zero.
     * 
     * Array keys are not compared, but preserved. Duplicates in $array1 are treated the same way
     *
     * @param array $array1
     *            The array to compare from
     * @param array $array2
     *            An array to compare against.
     * @param array $
     *            ... More arrays to compare against.
     * @return array an array containing all the entries from array1 that are not present in any of the other arrays.
     */
    public function diff(array $array1, array $array2 /*, [array $array3, [...]]*/)
	{
        $arrays = func_get_args();
        $callback = array(
            $this->getComparator(),
            'compare'
        );
        return call_user_func_array('array_udiff', array_merge($arrays, array(
            $callback
        )));
    }

    /**
     * Computes the intersection of arrays based on the Comparator.
     *
     * Objects $o1, $o2 are considered equal if $comparator->compare($o1,$o2) returns zero.
     * 
     * Array keys are not compared, but preserved.
     *
     * @param array $array
     *            The array with master values to check.
     * @param array $array2
     *            An array to compare values against.
     * @param array $
     *            ... More arrays to compare against.
     * @return array an array containing all of the values in array1 whose values exist in all of the parameters.
     */
    public function intersect(array $array, array $array2 /*, [array $array3, [...]]*/)
	{
        $arrays = func_get_args();
        $callback = array(
            $this->getComparator(),
            'compare'
        );
        return call_user_func_array('array_uintersect', array_merge($arrays, array(
            $callback
        )));
    }

    /**
     * Removes duplicate objects from an array based on the Comparator.
     *
     * Objects $o1, $o2 are considered equal if $comparator->compare($o1,$o2) returns zero.
     *
     * The resulting array will be sorted, keys maintained, however for same items it is undefined which one is kept.
     * 
     * @param array $array The input array
     * @return array The filtered array
     */
    public function unique(array $array)
    {
        $sorter = (new SortTool)->setComparator($this->getComparator());
        $sorter->sortAssociative($array);
        foreach ($array as $key => $value) {
            if (isset($_last) && ($this->getComparator()->compare($_last, $value) == 0)) {
                unset($array[$key]);
            }
            $_last = $value;
        }
        return $array;
    }
}