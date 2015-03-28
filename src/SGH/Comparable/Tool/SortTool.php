<?php
namespace SGH\Comparable\Tool;

use SGH\Comparable\Comparator;
use SGH\Comparable\Comparator\ComparableComparator;
use SGH\Comparable\Comparator\ReverseComparator;

/**
 * Comparator tool to sort objects, using Comparators
 *
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2015 SGH informationstechnologie UG
 * @license BSD
 * @link http://creativecommons.org/licenses/BSD/
 * @package Comparable
 * @since 1.0.0
 */
class SortTool
{

    /**
     * The Comparator to be used for sorting
     * 
     * @var Comparator
     */
    private $comparator;

    /**
     * Returns the comparator to be used, defaults to
     * ComparableComparator if $comparator has not been specified
     *
     * @return Comparator the Comparator
     */
    public function getComparator()
    {
        if ($this->comparator === null) {
            $this->comparator = new ComparableComparator();
        }
        return $this->comparator;
    }

    /**
     * Sets $comparator
     *
     * @param Comparator $comparator
     *            The Comparator to be used
     * @return $this
     */
    public function setComparator(Comparator $comparator = null)
    {
        $this->comparator = $comparator;
        return $this;
    }

    /**    
     * Revert sort order of current comparator
     * 
     * @return \SGH\Comparable\Tool\SortTool
     */
    public function reverse()
    {
        if ($this->getComparator() instanceof ReverseComparator) {
            $this->setComparator($this->getComparator()->getOriginalComparator());
        } else {
            $this->setComparator(new ReverseComparator($this->getComparator()));
        }
        return $this;
    }

    /**
     * Sort an array of objects based on the Comparator
     *
     * @param array $array
     *            Array of objects
     * @return boolean Returns TRUE on success or FALSE on failure.
     */
    public function sort(array &$array)
    {
        return usort($array, array(
            $this->getComparator(),
            'compare'
        ));
    }

    /**
     * Sort an array of objects, maintaining array keys, based on the Comparator
     *
     * @param array $array
     *            Array of objects
     * @return boolean Returns TRUE on success or FALSE on failure.
     */
    public function sortAssociative(array &$array)
    {
        return uasort($array, array(
            $this->getComparator(),
            'compare'
        ));
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
     * @param array $arrays
     *            Array of references to the arrays that should be sorted by the first of them
     * @return boolean Returns TRUE on success or FALSE on failure.
     */
    public function multisort(array $arrays)
    {
        $ref = reset($arrays);
        $refNumericKeys = array_values($ref);
        $this->sortAssociative($refNumericKeys);
        $newOrder = array_flip(array_keys($refNumericKeys));
        ksort($newOrder);
        
        $params = array_merge(array(
            &$newOrder
        ), $arrays);
        if (false === call_user_func_array('array_multisort', $params)) {
            return false;
        }
        return true;
    }
}
