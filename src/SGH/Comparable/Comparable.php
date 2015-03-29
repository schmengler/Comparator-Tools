<?php
namespace SGH\Comparable;

/**
 * Comparable interface
 *
 * The Comparable interface allows classes to implement a default comparing method
 * that is used by the ComparableComparator
 *
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2015 SGH informationstechnologie UG
 * @license MIT
 * @link http://opensource.org/licenses/mit-license.php
 * @package Comparable
 * @since 1.0.0
 */
interface Comparable
{

    /**
     * Compares this object with the specified object.
     * 
     * Returns a negative integer, zero, or a positive integer as this object is less than, equal to, or greater than the specified object.
     * 
     * The implementor must ensure sgn(x.compareTo(y)) == -sgn(y.compareTo(x)) for all x and y. (This implies that x.compareTo(y) must throw an exception iff y.compareTo(x) throws an exception.)
     *
     * The implementor must also ensure that the relation is transitive: (x.compareTo(y)>0 && y.compareTo(z)>0) implies x.compareTo(z)>0.
     *
     * Finally, the implementor must ensure that x.compareTo(y)==0 implies that sgn(x.compareTo(z)) == sgn(y.compareTo(z)), for all z.
     *
     * In the foregoing description, the notation sgn(expression) designates the mathematical signum function, which is defined to return one of -1, 0, or 1 according to whether the value of expression is negative, zero or positive.
     *
     * @param object $object
     *            the object to be compared
     * @return int a negative integer, zero, or a positive integer as this object is less than, equal to, or greater than the specified object.
     * @throws ComparatorException if objects are not comparable to each other
     */
    public function compareTo($object);
}