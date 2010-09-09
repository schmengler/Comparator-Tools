<?php
/**
 * Decorator that reverses a comparation
 * 
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2010 SGH informationstechnologie UG
 * @license BSD
 * @link http://creativecommons.org/licenses/BSD/ 
 * @package ComparatorTools
 * @version 0.9
 */
class ReverseComparator implements Comparator
{
	private $comparator;
	
	public function __construct(Comparator $comparator)
	{
		$this->comparator = $comparator;
	}
	/**
	 * @param object $object1
	 * @param object $object2
	 * @return numeric
	 */
	public function compare($object1, $object2)
	{
		return - $this->comparator->compare($object1, $object2);
	}
}