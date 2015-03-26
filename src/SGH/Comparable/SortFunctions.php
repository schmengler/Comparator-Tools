<?php
namespace SGH\Comparable;

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
		return \osort($array, $comparator);
	}
	public static function asort(array &$array, Comparator $comparator = null)
	{
		return \oasort($array, $comparator);
	}
	public static function rsort(array &$array, Comparator $comparator = null)
	{
		return \orsort($array, $comparator);
	}
	public static function arsort(array &$array, Comparator $comparator = null)
	{
		return \oarsort($array, $comparator);
	}
	public static function multisort(array &$array, Comparator $comparator = null)
	{
		return \array_omultisort($array, $comparator);
	}
}
