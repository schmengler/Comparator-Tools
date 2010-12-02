<pre><?php

require '../comparatortools.lib.php';
require 'ExampleData.php';


echo "################### multisort() ####################\n";
// array_multisort with Example objects:
$os = new ObjectSorter();
$arr1 = array(new ExampleData(1), new ExampleData(0), new ExampleData(2), new ExampleData(-1), new ExampleData(0));
$arr2 = array( 'one', 'zero', 'two', 'minus one', 'zero(2)');
$arrays = array(
	&$arr1,
	&$arr2
);
echo "unsorted arrays:\n";
var_dump($arrays);
$os->multisort($arrays);
echo "after multisort():\n";
var_dump($arrays);

echo "################### unique() ####################\n";

// now remove one of the Example(0) objects from $arr1:
echo "array with multiple equivalent values:\n";
var_dump($arr1);
$oam = new ObjectArrayModifier();
$oam->unique($arr1);
echo "after unique():\n";
var_dump($arr1);

echo "################### ObjectComparator ####################\n";
// ObjectComparator to check for real identity of objects
$oam->setComparator(new ObjectComparator());
// three similar instances:
$arr3 = array(new stdClass, new stdClass, new stdClass);
// + same instance as first item:
$arr3[] = $arr3[0];
echo "array with multiple equal values:\n";
var_dump($arr3);
$oam->unique($arr3);
echo "after unique() with ObjectComparator:\n";
var_dump($arr3);

echo "################### SplFileInfoComparator ####################\n";
// use ObjectSortingIterator with ObjectSorter to retrieve a sorted FilesystemIterator:
$it = new ObjectSortingIterator(
	new RecursiveDirectoryIterator(dirname(__FILE__), 4096), // 4096 = FilesystemIterator::SKIP_DOTS in PHP 5.3
	new ObjectSorter(new SplFileInfoComparatorMTime())
);
//NOTE: Does not work with DirectoryIterator. Use RecursiveDirectoryIterator instead (without RecursiveIteratorIterator if you don't want to scan recursively)
echo "ObjectSortingIterator with SplFileInfoComparatorMTime:\n"; 
foreach($it as $file)
{
	echo date('d.m. H:i', $file->getMTime()), ' - ', $file->getFileName(), "\n";
}
?></pre>