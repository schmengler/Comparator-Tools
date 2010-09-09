<?php
/**
 * Comparator tool to sort arrays of objects
 * 
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2010 SGH informationstechnologie UG
 * @license BSD
 * @link http://creativecommons.org/licenses/BSD/ 
 * @package ComparatorTools
 * @version 0.9
 */
class ObjectSorter extends ComparatorTool
{
	/**
	 * @var boolean
	 */
	private $maintainKeys = false;
	/**
	 * @var boolean
	 */
	private $reverse = false;
	
	/**
	 * @return boolean the $maintainKeys
	 */
	public function getMaintainKeys() {
		return $this->maintainKeys;
	}

	/**
	 * @return boolean the $reverse
	 */
	public function getReverse() {
		return $this->reverse;
	}

	/**
	 * @param boolean $maintainKeys the $maintainKeys to set
	 */
	public function setMaintainKeys($maintainKeys) {
		$this->maintainKeys = (bool) $maintainKeys;
		return $this;
	}

	/**
	 * @param boolean $reverse the $reverse to set
	 */
	public function setReverse($reverse) {
		$this->reverse = (bool) $reverse;
		return $this;
	}

	/**
	 * Sort an array of objects based on the Comparator
	 * 
	 * @param array $array Array of objects
	 * @return boolean Returns TRUE on success or FALSE on failure.
	 */
	public function sort(array &$array)
	{
		try {
			$comparator = $this->reverse
				? new ReverseComparator($this->getComparator()) // decorate
				: $this->getComparator();
			return $this->maintainKeys
				? uasort($array, array($comparator, 'compare'))
				: usort($array, array($comparator, 'compare'));
		} catch (ComparatorException $e) {
			return $this->handleException($e, __METHOD__);
		}
	}

	/**
	 * Sort multiple arrays of objects based on the Comparator
	 * 
	 * Works like array_multisort: first array is sorted by $this->comparator,
	 * additional arrays by the first array.
	 * NOTE: The arrays must be provided as an array of references. Example:
	 * <code>
	 * $os = new ObjectSort();
	 * $array1 = array(new ComparableObject(3), new ComparableObject(1), new ComparableObject(2));
	 * $array2 = array('object three', 'object one', 'object two');
	 * $array3 = array('foo', 'bar', 'baz');
	 * $os->multisort(array(&$array1, &$array2, &$array3));
	 * </code>
	 * 
	 * @param array $arrays Array of references to the arrays that should be sorted by the first of them
	 * @return boolean Returns TRUE on success or FALSE on failure.
	 */
	public function multisort(array &$arrays)
	{
		$ref = reset($arrays);
		$ref_numeric = array_values($ref);
		$ref_sorter = new ObjectSorter($this->getComparator());
		$ref_sorter->setMaintainKeys(true)->sort($ref_numeric);
		$new_order = array_flip(array_keys($ref_numeric));
		$this->reverse
			? krsort($new_order)
			: ksort($new_order);

		$params = array_merge(array($new_order), $arrays);
		if (false === call_user_func_array('array_multisort', $params)) {
			return false;
		}
		if (false === $this->maintainKeys) {
			foreach($arrays as &$array) {
				$array = array_values($array);
			}
		}
		return true;
	}
	

}