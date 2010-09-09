<?php
/**
 * Comparator for SplFileInfo objects
 * 
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2010 SGH informationstechnologie UG
 * @license BSD
 * @link http://creativecommons.org/licenses/BSD/
 * @package ComparatorTools
 * @version 0.9
 */
class SplFileInfoComparatorCTime extends SplFileInfoComparator
{
	/**
	 * @param SplFileInfo $object1
	 * @param SplFileInfo $object2
	 */
	public function compare($object1, $object2)
	{
		$this->checkTypes($object1, $object2);
		return $object1->getCTime() - $object2->getCTime();
	}
}