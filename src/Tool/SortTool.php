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
 * @license MIT
 * @link http://opensource.org/licenses/mit-license.php
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
     * Sort an array based on the Comparator. It will assign new keys to the array.
     *
     * @param array $array
     *            Array of objects
     * @return void
     */
    public function sort(array &$array)
    {
        usort($array, array(
            $this->getComparator(),
            'compare'
        ));
    }

    /**
     * Sort an array of objects, maintaining array keys, based on the Comparator
     *
     * @param array $array
     *            Array of objects
     * @return void
     */
    public function sortAssociative(array &$array)
    {
        uasort($array, array(
            $this->getComparator(),
            'compare'
        ));
    }

    /**
     * Sort multiple arrays of objects based on the Comparator
     *
     * Works like array_multisort in "sort multiple arrays" mode: first array is sorted by $this->comparator,
     * additional arrays by the first array.
     * NOTE: The arrays must be provided as an array of references. Example:
     * <code>
     * $sortTool = new SortTool();
     * $array1 = array(new ComparableObject(3), new ComparableObject(1), new ComparableObject(2));
     * $array2 = array('object three', 'object one', 'object two');
     * $array3 = array('foo', 'bar', 'baz');
     * $sortTool->multisort(array(&$array1, &$array2, &$array3));
     * </code>
     *
     * @param array $arrays
     *            Array of references to the arrays that should be sorted by the first of them
     * @return void
     * @throws \InvalidArgumentException if $arrays is not an array of arrays with same sizes
     */
    public function multisort(array $arrays)
    {
        $ref = reset($arrays);
        foreach ($arrays as $key => $array) {
            if (! is_array($array)) {
                throw new \InvalidArgumentException(sprintf('%s expects parameter 1 to be array of arrays, element "%s" is of type "%s".', __METHOD__, $key, gettype($array)));
            }
            if (count($array) !== count($ref)) {
                throw new \InvalidArgumentException(sprintf('%s: array sizes are inconsistent.', __METHOD__));
            }
        }
        $refNumericKeys = array_values($ref);
        $this->sortAssociative($refNumericKeys);
        $newOrder = array_flip(array_keys($refNumericKeys));
        ksort($newOrder);
        
        $params = array_merge(array(
            &$newOrder
        ), $arrays);
        call_user_func_array('array_multisort', $params);
    }
}
