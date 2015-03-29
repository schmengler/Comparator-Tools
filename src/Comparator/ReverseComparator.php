<?php
namespace SGH\Comparable\Comparator;

use SGH\Comparable\Comparator;

/**
 * Decorator that reverses a comparison
 *
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2015 SGH informationstechnologie UG
 * @license MIT
 * @link http://opensource.org/licenses/mit-license.php
 * @package Comparable
 * @since 1.0.0
 */
class ReverseComparator implements Comparator
{

    private $comparator;

    /**
     * Constructor, takes another comparator that will be decorated in reverse order
     * 
     * @param Comparator $comparator
     */
    public function __construct(Comparator $comparator)
    {
        $this->comparator = $comparator;
    }

    /**
     * (non-PHPdoc)
     * @see \SGH\Comparable\Comparator::compare()
     */
    public function compare($object1, $object2)
    {
        return - $this->comparator->compare($object1, $object2);
    }
    
    /**
     * Returns the original (not reversed) Comparator instance
     * 
     * @return Comparator
     */
    public function getOriginalComparator()
    {
        return $this->comparator;
    }
}