<?php
/**
 * The comparator compares objects of ExampleData but orders by even numbers first, odd numbers last
 */
class ExampleComparator implements Comparator
{
	public function compare($object1, $object2)
	{
		if (!$object1 instanceof ExampleData) throw new ComparatorException('object1 is not of type ExampleData');
		if (!$object2 instanceof ExampleData) throw new ComparatorException('object2 is not of type ExampleData');
		$v1 = $object1->getValue();
		$v2 = $object2->getValue();
		if ($v1 % 2 == 0 && $v2 % 2 == 1) return -1;
		if ($v1 % 2 == 1 && $v2 % 2 == 0) return 1;
		return $v1 - $v2;
	}
}
