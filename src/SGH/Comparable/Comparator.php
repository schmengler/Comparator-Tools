<?php
namespace SGH\Comparable;

/**
 * Comparator interface
 *
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2015 SGH informationstechnologie UG
 * @license MIT
 * @link http://opensource.org/licenses/mit-license.php
 * @package Comparable
 * @since 1.0.0
 */
interface Comparator
{

    /**
     * Compares its two arguments.
     * 
     * Returns a negative integer, zero, or a positive integer as the first argument is less than, equal to, or greater than the second.
     *
     * The implementor must ensure that sgn(compare(x, y)) == -sgn(compare(y, x)) for all x and y. (This implies that compare(x, y) must throw an exception if and only if compare(y, x) throws an exception.)
     *
     * The implementor must also ensure that the relation is transitive: ((compare(x, y)>0) && (compare(y, z)>0)) implies compare(x, z)>0.
     *
     * Finally, the implementor must ensure that compare(x, y)==0 implies that sgn(compare(x, z))==sgn(compare(y, z)) for all z.
     *
     * In the foregoing description, the notation sgn(expression) designates the mathematical signum function, which is defined to return one of -1, 0, or 1 according to whether the value of expression is negative, zero or positive.
     *
     * @param object $object1
     *            The first object to be compared
     * @param object $object2
     *            The second object to be compared
     * @return int a negative integer, zero, or a positive integer as the first argument is less than, equal to, or greater than the second.
     * @throws ComparatorException if objects are not comparable to each other
     */
    public function compare($object1, $object2);
}