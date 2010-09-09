<pre><?php

require '../comparatortools.lib.php';
/*
 * ExampleData: class with Comparable interface
 */
require 'ExampleData.php';
/**
 * ExampleComparator: an additional comparator class for ExampleData
 */
require 'ExampleComparator.php';

/*
 * random ordered data objects
 */
$objects = include('randomdata.inc');

/*
 * ObjectSorter instance:
 */
$os = new ObjectSorter();



/*
 * sort objects via Comparable interface (maintain keys)
 */
$os->setMaintainKeys(true);
$os->sort($objects);

echo "Sorted object array (Comparable interface, maintain keys):\n";
echo "----------------------------------------------------------\n";
var_dump($objects);

$os->setMaintainKeys(false);
shuffle($objects);



/*
 * sort objects via Comparable interface (default)
 */
$os->sort($objects);

echo "Sorted object array (Comparable interface, default):\n";
echo "----------------------------------------------------\n";
var_dump($objects);

shuffle($objects);



/*
 * sort objects via Comparable interface (reverse)
 */
$os->setReverse(true);
$os->sort($objects);

echo "Sorted object array (Comparable interface, reverse):\n";
echo "----------------------------------------------------\n";
var_dump($objects);

$os->setReverse(false);
shuffle($objects);



/*
 * now sort with a Comparator. The Comparator class defines that even numbers come first, odd last
 */
$os->setComparator(new ExampleComparator);
$os->sort($objects);

echo "Sorted object array (ExampleComparator):\n";
echo "----------------------------------------\n";
var_dump($objects);



?></pre>