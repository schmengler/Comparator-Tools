<?php
namespace SGH\Comparable\Tool;

/**
 * Comparator tool to modify arrays of objects.
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
class SetTool extends AbstractTool
{
	/**
	 * Computes the difference of arrays based on the Comparator.
	 * 
	 * Objects $o1, $o2 are considered equal if $comparator->compare($o1,$o2) returns zero.
	 * 
	 * @param array $array The array to compare from
	 * @param array $array2 An array to compare against.
	 * @param array $ ... More arrays to compare against.
	 * @return array|false Returns an array containing all the entries from array1 that are not present in any of the other arrays or FALSE on error.
	 */
	public function diff(array $array, array $array2 /*, [array $array3, [...]]*/)
	{
		$arrays = func_get_args();
		$callback = array($this->getComparator(), 'compare');
		return call_user_func_array('array_udiff', array_merge($arrays, array($callback)));
	}
	/**
	 * Computes the intersection of arrays based on the Comparator.
	 * 
	 * Objects $o1, $o2 are considered equal if $comparator->compare($o1,$o2) returns zero.
	 * 
	 * @param array $array The array with master values to check.
	 * @param array $array2 An array to compare values against.
	 * @param array $ ... More arrays to compare against.
	 * @return array|false Returns an array containing all of the values in array1 whose values exist in all of the parameters or FALSE on error.
	 */
	public function intersect(array $array, array $array2 /*, [array $array3, [...]]*/)
	{
		$arrays = func_get_args();
		$callback = array($this->getComparator(), 'compare');
		return call_user_func_array('array_uintersect', array_merge($arrays, array($callback)));
	}
	/**
	 * Removes duplicate objects from an array based on the Comparator.
	 * 
	 * Objects $o1, $o2 are considered equal if $comparator->compare($o1,$o2) returns zero.
	 * 
	 * @param array $array
	 * @return boolean Returns TRUE on success or FALSE on failure.
	 */
	public function unique(array $array)
	{
		$sorter = new SortTool($this->getComparator());
		$sorter->sort($array);
		foreach($array as $key=>$value) {
			if (isset($_last) && ($this->getComparator()->compare($_last, $value)==0)) {
				unset($array[$key]);
			}
			$_last = $value;
		}
		return $array;
	}
}