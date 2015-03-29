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
 * @license MIT
 * @link http://opensource.org/licenses/mit-license.php
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
        return $this->callFunction('array_udiff', func_get_args());
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
	    return $this->callFunction('array_uintersect', func_get_args());
    }
    
    /**
     * Computes the difference of arrays based on the Comparator, with additional index check.
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
     * @return array an array containing all the entries from array1 that are not present in any of the other arrays. Keys are also taken into account for comparison.
     */
    public function diffAssoc(array $array1, array $array2 /*, [array $array3, [...]]*/)
    {
        return $this->callFunction('array_udiff_assoc', func_get_args());
    }
    
    /**
     * Computes the intersection of arrays based on the Comparator, with additional index check.
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
     * @return array an array containing all of the values in array1 whose values exist in all of the parameters. Keys are also taken into account for comparison.
     */
    public function intersectAssoc(array $array, array $array2 /*, [array $array3, [...]]*/)
    {
        return $this->callFunction('array_uintersect_assoc', func_get_args());
    }
    
	/**
     * @param function core function that takes an arbitrary number of arrays and a callable as arguments
     * @param arrays the arrays to pass as arguments
     */
    private function callFunction($function, $arrays)
    {
        $callback = array(
            $this->getComparator(),
            'compare'
        );
        return call_user_func_array($function, array_merge($arrays, array(
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