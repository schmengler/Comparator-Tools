<?php
namespace SGH\Comparable\Comparator;

use SGH\Comparable\Comparator;

/**
 * Decorator that adds __invoke method to a comparator, making it callable
 *
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2015 SGH informationstechnologie UG
 * @license MIT
 * @link http://opensource.org/licenses/mit-license.php
 * @package Comparable
 * @since 1.0.0
 */
class InvokableComparator implements Comparator
{

    /**
     * The original comparator
     * 
     * @var Comparator
     */
    private $comparator;

    /**
     * Constructor, takes another comparator that will be decorated
     *
     * @param Comparator $comparator the original comparator
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
        return $this->comparator->compare($object1, $object2);
    }
    /**
     * Magic method to make objects callable, invoking the compare method
     * 
     * @param unknown $object1
     * @param unknown $object2
     * @return int
     */
    public function __invoke($object1, $object2)
    {
        return $this->compare($object1, $object2);
    }
}