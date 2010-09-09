<?php
/**
 * Abstract comparator for SplFileInfo objects
 * 
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2010 SGH informationstechnologie UG
 * @license BSD
 * @link http://creativecommons.org/licenses/BSD/
 * @package ComparatorTools
 * @version 0.9
 */
abstract class SplFileInfoComparator implements Comparator
{
	protected function checkTypes($object1, $object2)
	{
		if (!$object1 instanceof SplFileInfo) {
			throw new ComparatorException('$object1 (type: ' . gettype($object1) . ') is no instance of SplFileInfo.');
		}
		if (!$object2 instanceof SplFileInfo) {
			throw new ComparatorException('$object2 (type: ' . gettype($object2) . ') is no instance of SplFileInfo.');
		}
	}
}
