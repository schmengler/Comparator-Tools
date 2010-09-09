<?php
/**
 * Converts an iterator over objects to a sorted iterator, based on a given
 * ObjectSorter instance.
 * 
 * Example:
 * <code>
 * 	$it = new ObjectSortingIterator(
 * 		new RecursiveDirectoryIterator('.'),
 * 		new ObjectSorter(new SplFileInfoComparatorSize()
 * 	);
 * 	foreach($it) as $file) {
 * 		echo $file->getPathName() . ' (' . $file->getSize() .  ")<br>\n";
 * 	}
 * </code>
 * 
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2010 SGH informationstechnologie UG
 * @license BSD
 * @link http://creativecommons.org/licenses/BSD/ 
 * @package ComparatorTools
 * @version 0.9
 *
 * Thanks to Soenke Ruempler for the SortingIterator decorator inspiriation
 * @link http://www.ruempler.eu/2008/08/09/php-sortingiterator/
 */
class ObjectSortingIterator implements IteratorAggregate
{
	private $iterator;
	private $objectSorter;

	/**
	 * @param Traversable $iterator
	 * @param ObjectSorter $objectSorter
	 * @param boolean $clone clones the elements of $iterator, this is necessary
	 * for Iterators that return the same instance in different states like the
	 * evil DirectoryIterator.
	 * @todo still does not work with DirectoryIterator. Other solutions?
	 * @link http://bugs.php.net/bug.php?id=49755
	 */
	public function __construct(Traversable $iterator, ObjectSorter $objectSorter = null, $clone = false)
	{
		$this->objectSorter = ($objectSorter === null
			? new ObjectSorter()
			: $objectSorter
		);
		if ($clone) {
			$array = array();
			foreach($iterator as $key=>$value) {
				$array[$key] = clone $value;
			}
		} else {
			$array = iterator_to_array($iterator);
		}
		$this->objectSorter->sort($array);
		$this->iterator = new ArrayIterator($array);
	}


	public function getIterator()
	{
		return $this->iterator;
	}
}