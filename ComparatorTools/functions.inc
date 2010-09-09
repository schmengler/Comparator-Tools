<?php
/**
 * This file provides procedural access to the functions of ObjectSorter and
 * ObjectArrayModifier. It may be convenient to just write
 * <code>osort($array, $comparator);</code>
 * and so on without having to care about the ComparatorTool classes.
 * 
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2010 SGH informationstechnologie UG
 * @license BSD
 * @link http://creativecommons.org/licenses/BSD/ 
 * @package ComparatorTools
 * @version 0.9
 */

/**
 * Returns a new ObjectSorter instance
 * 
 * @return ObjectSorter
 */
function object_sorter()
{
	return new ObjectSorter();
}
/**
 * Returns a new ObjectArrayModifier instance
 * 
 * @return ObjectArrayModifier
 */
function object_array_modifier()
{
	return new ObjectArrayModifier();
}
/**
 * Sort an array of objects by their Comparable Interface or a Comparator
 * 
 * @param array $array Array of objects, comparable by $comparator
 * @param Comparator $comparator A comparator. If null, the dafault
 * ComparableComparator will be used.
 * @return Returns TRUE on success or FALSE on failure.
 */
function osort(array &$array, $comparator = null)
{
	return object_sorter()->setComparator($comparator)->sort($array);
}
/**
 * Sorts an array of objects by their Comparable Interface or a Comparator in reverse order
 * 
 * @param array $array Array of objects, comparable by $comparator
 * @param Comparator $comparator A comparator. If null, the dafault
 * ComparableComparator will be used.
 * @return Returns TRUE on success or FALSE on failure.
 */
function orsort(array &$array, $comparator = null)
{
	return object_sorter()->setReverse(true)->setComparator($comparator)->sort($array);
}
/**
 * Sort an array of objects by their Comparable Interface or a Comparator and maintain index association
 * 
 * @param array $array Array of objects, comparable by $comparator
 * @param Comparator $comparator A comparator. If null, the dafault
 * ComparableComparator will be used.
 * @return Returns TRUE on success or FALSE on failure.
 */
function oasort(array &$array, $comparator = null)
{
	return object_sorter()->setMaintainKeys(true)->setComparator($comparator)->sort($array);
}
/**
 * Sort an array of objects by their Comparable Interface or a Comparator in reverse order and maintain index association
 * 
 * @param array $array Array of objects, comparable by $comparator
 * @param Comparator $comparator A comparator. If null, the dafault
 * ComparableComparator will be used.
 * @return Returns TRUE on success or FALSE on failure.
 */
function oarsort(array &$array, $comparator = null)
{
	return object_sorter()->setMaintainKeys(true)->setReverse(true)->setComparator($comparator)->sort($array);
}
/**
 * Sort multiple arrays of objects by their Comparable Interface or a Comparator
 * 
 * Works like array_multisort: first array is sorted by $comparator, additional
 * arrays by the first array. Index associations are maintained.
 * NOTE: The arrays must be provided as an array of references. Example:
 * <code>
 * $array1 = array(new ComparableObject(3), new ComparableObject(1), new ComparableObject(2));
 * $array2 = array('object three', 'object one', 'object two');
 * $array3 = array('foo', 'bar', 'baz');
 * array_omultisort(array(&$array1, &$array2, &$array3));
 * </code>
 * 
 * @param array $arrays Array of references to the arrays that should be sorted by the first of them

 * @param array $arrays
 * @param Comparator $comparator A comparator. If null, the dafault
 * ComparableComparator will be used.
 * @return Returns TRUE on success or FALSE on failure.
 */
function array_omultisort(array &$arrays, Comparator $comparator = null)
{
	return object_sorter()->setMaintainKeys(true)->setComparator($comparator)->multisort($arrays);
}
/**
 * Removes duplicate objects from an array based on their Comparable Interface or a Comparator.
 * 
 * Objects $o1, $o2 are considered equal if $comparator->compare($o1,$o2) returns zero.
 * 
 * @param array $array
 * @param Comparator $comparator A comparator. If null, the dafault
 * ComparableComparator will be used.
 * @return array|false Returns the filtered array or FALSE on error.
 */
function array_ounique(array &$array, Comparator $comparator = null)
{
	return object_array_modifier()->setComparator($comparator)->unique($array);
}
/**
 * Computes the difference of arrays based on the Comparable Interface of contained objects or a Comparator.
 * 
 * Objects $o1, $o2 are considered equal if $comparator->compare($o1,$o2) returns zero.
 * 
 * @param array $array The array to compare from
 * @param array $array2 An array to compare against.
 * @param array $ ... More arrays to compare against.
 * @param Comparator $comparator A comparator. If null, the dafault
 * ComparableComparator will be used.
 * @return array|false Returns an array containing all the entries from array1 that are not present in any of the other arrays or FALSE on error.
 */
function array_odiff(array $array, array $array2 /*, [array $array3, [...]], Comparator $comparator = null*/)
{
	$args = func_get_args();
	$oam = object_array_modifier();
	if (func_get_arg(func_num_args() - 1) instanceof Comparator) {
		$oam->setComparator(array_pop($args));
	} else {
		$oam->setComparator(null);
	}
	return call_user_func_array(array($oam, 'diff'), $args);
}
/**
 * Computes the intersection of arrays based on the Comparable Interface of contained objects or a Comparator.
 * 
 * Objects $o1, $o2 are considered equal if $comparator->compare($o1,$o2) returns zero.
 * 
 * @param array $array The array with master values to check.
 * @param array $array2 An array to compare values against.
 * @param array $ ... More arrays to compare against.
 * @param Comparator $comparator A comparator. If null, the dafault
 * ComparableComparator will be used.
 * @return array|false Returns an array containing all of the values in array1 whose values exist in all of the parameters or FALSE on error.
 */
function array_ointersect(array $array, array $array2 /*, [array $array3, [...]], Comparator $comparator = null*/)
{
	$args = func_get_args();
	$oam = object_array_modifier();
	if (func_get_arg(func_num_args() - 1) instanceof Comparator) {
		$oam->setComparator(array_pop($args));
	} else {
		$oam->setComparator(null);
	}
	return call_user_func_array(array($oam, 'intersect'), $args);
}