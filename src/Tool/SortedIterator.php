<?php
namespace SGH\Comparable\Tool;

use SGH\Comparable\Comparator;
/**
 * Converts an iterator to a sorted iterator, based on a given Comparator.
 * Uses ComparableComparator by default.
 *
 * Example:
 * <code>
 * 	$it = new SortedIterator(
 * 		new RecursiveDirectoryIterator('.'), true
 * 	);
 *  $it->setComparator(new FileSizeComparator());
 * 	foreach($it) as $file) {
 * 		echo $file->getPathName() . ' (' . $file->getSize() .  ")<br>\n";
 * 	}
 * </code>
 *
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2015 SGH informationstechnologie UG
 * @license MIT
 * @link http://opensource.org/licenses/mit-license.php
 * @package Comparable
 * @since 1.0.0
 *
 * Thanks to Soenke Ruempler for the SortingIterator decorator inspiriation
 * @link http://www.ruempler.eu/2008/08/09/php-sortingiterator/
 */
class SortedIterator implements \IteratorAggregate
{
    private $originalIterator;
    private $sortedIterator;
    private $cloneItems;
    private $sortTool;

    /**
     * Constructor, decorate given iterator, make it sorted. The original iterator will be iterated as soon as
     * SortedIterator::getIterator() is called.
     * 
     * @param \Traversable $originalIterator            
     * @param bool $cloneItems
     *            clones the elements of $iterator, this is necessary for Iterators that return the same instance
     *            in different states like the evil DirectoryIterator.
     * @link http://bugs.php.net/bug.php?id=49755
     * @todo still does not work with DirectoryIterator, only RecursiveDirectoryIterator.
     */
    public function __construct(\Traversable $originalIterator, $cloneItems = false)
    {
        $this->sortTool = new SortTool();
        $this->originalIterator = $originalIterator;
        $this->cloneItems = $cloneItems;
    }
    /**
     * Set Comparator to be used for sorting
     * 
     * @param Comparator $comparator
     * @return $this
     */
    public function setComparator(Comparator $comparator = null)
    {
        $this->sortTool->setComparator($comparator);
        return $this;
    }

    /**
     * (non-PHPdoc)
     * @see IteratorAggregate::getIterator()
     */ 
    public function getIterator()
    {
    	if ($this->sortedIterator === null) {
    	    if ($this->cloneItems) {
    	        $array = array();
                foreach ($this->originalIterator as $key => $value) {
                    $array[$key] = clone $value;
                }
            } else {
    	        $array = iterator_to_array($this->originalIterator);
    	    }
    	    $this->sort($array);
    	    $this->sortedIterator = new \ArrayIterator($array);
    	}
    	return $this->sortedIterator;
    }
    /**
     * Sorts array
     * 
     * @param mixed[] $array
     */
    protected function sort(&$array)
    {
        $this->sortTool->sort($array);
    }
}