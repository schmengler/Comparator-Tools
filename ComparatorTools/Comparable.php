<?php
/*
 * just in case that a Comparable SPL Interface comes someday
 */
if (interface_exists('Comparable')) {
	return;
}

/**
 * The Comparable interface allows classes to implement a default comparing method
 * that is used by ObjectSorter etc.
 * 
 * @see ComparableComparator
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2010 SGH informationstechnologie UG
 * @license BSD
 * @link http://creativecommons.org/licenses/BSD/ 
 * @package ComparatorTools
 * @version 0.9
 */
interface Comparable
{
	/**
	 * @param object $object
	 * @return numeric negative value if $this < $object, positive if $this > $object, 0 otherwise (if objects are considered equal)
	 * @throws ComparatorException if objects are not comparable to each other
	 */
	public function compareTo($object);
}