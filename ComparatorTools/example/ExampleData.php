<?php
/**
 * ExampleData contains an integer property that the compareTo method refers to
 */
class ExampleData implements Comparable
{
	/*
	 * @var int
	 */
	private $value;
	public function __construct($value) {
		$this->value = $value;
	}
	public function compareTo($object) {
		if (!$object instanceof ExampleData) throw new ComparatorException('object is not of type ExampleData');
		return $this->value - $object->value;
	}
	public function getValue() {
		return $this->value;
	}
}