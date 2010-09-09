<?php
/*
 * generate random ordered data objects
 */
$numbers = range(0,5);
shuffle($numbers);
$objects = array();
foreach($numbers as $number) {
	$objects['key_' . $number] = new ExampleData($number);
}
echo "Shuffled object array:\n";
echo "----------------------\n";
var_dump($objects);
return $objects;