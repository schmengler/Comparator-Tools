<?php
/**
 * The Comparator interface
 * 
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2010 SGH informationstechnologie UG
 * @license BSD
 * @link http://creativecommons.org/licenses/BSD/ 
 * @package ComparatorTools
 * @version 0.9
 */
interface Comparator
{
	/**
	 * @param object $object1
	 * @param object $object2
	 * @return numeric Negative value if $object1 < $object2, positive if $object1 > $object2, 0 otherwise
	 * @throws ComparatorException if objects are not comparable to each other
	 */
	public function compare($object1, $object2);
}