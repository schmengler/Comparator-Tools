+-----------------------------------------------------------------------------+
|                            ComparatorTools                                  |
+-----------------------------------------------------------------------------+

- Synopsis
- Requirements
- Files
- Simple Usage
- Procedural Interface
- Error Handling

Synopsis
--------
This package provides sorting of objects that have a Comparable interface and
other useful functions with comparison of objects. With these tools the
"Comparable" and "Comparator" interfaces can be used like known from Java.


Requirements
------------
The package requires PHP 5.1 or later.

To use the package, just include comparatortools.lib.php. If you do not want the
additional procedural interface, remove the inclusion of functions.inc.


Files
-----
readme.txt - the file you are reading right now
license.txt - BSD license
comparatortools.lib.php - library loader, include this file to use the package
ComparatorTool.php - class file: abstract tool class
ObjectSorter.php - class file: tool class for sorting
ObjectArrayModifier.php - class file: tool class for other array modifications (diff, intersect, unique)
Comparator.php- class file: comparator interface
Comparable.php - class file: comparable interface
ComparatorException.php - class file: comparator exception
functions.inc - functions file: procedural interface (osort, orsort etc.)
Iterators/ObjectSortingIterator.php - class file: ObjectSorter functionality for iterators
Comparators/ComparableComparator.php - class file: comparator for Comparable interface
Comparators/ObjectComparator.php - class file: comparator for object identity
Comparators/ReverseComparator.php - class file: decorator class to revert comparator outcome
Comparators/SplFileInfoComparator.php - class file: abstract comparator for SplFileInfo objects
Comparators/SplFileInfoComparatorATime.php - class file: compare SplFileInfo objects by access time
Comparators/SplFileInfoComparatorCTime.php - class file: compare SplFileInfo objects by creation time
Comparators/SplFileInfoComparatorMTime.php - class file: compare SplFileInfo objects by modification time
Comparators/SplFileInfoComparatorName.php - class file: compare SplFileInfo objects by file name
Comparators/SplFileInfoComparatorSize.php - class file: compare SplFileInfo objects by file size
Comparators/SplFileInfoComparatorType.php - class file: compare SplFileInfo objects by file type
example/ExampleData.php - example: an implementation of the Comparable interface, used by the examples
example/ExampleComparator.php - example: an implementation of the Comparator interface, used by the examples
example/randomdata.inc - example: generation of a randomized object array
example/sort.php - example: some sorting
example/sort_procedural.php - example: same example but with the procedural interface
example/advanced.php - example: more examples


Simple Usage
------------

To give your classes the comparable functionality, just implement the Comparable
interface:

	class Foo implements Comparable
	{
		public function compareTo($object)
		{
		}
	}
	
The compareTo method will be called with another instance of Foo as parameter
and must return a negative value if ($this < $object) applies and a positive
value if ($this > $object) applies, 0 otherwise (the objects are considered
equal)

To use the tools - i.e. sort objects - instantiate a tool class (currently
available: ObjectSorter, ObjectArrayModifier):

	$tool = new ObjectSorter;
	$tool->sort($array_of_foo_objects);

For detailed description of the functions see phpDoc documentation inside the
tool class files.

It is also possible to implement separate comparator classes:

	class FooComparator implements Comparator
	{
		public function compare($object1, $object2)
		{
		}
	}

The compare method behaves just like the compareTo method but both objects are
passed as parameters.

To use a comparator, call the setComparator() method of the tool or pass the
comparator in the constructor:

	$fooTool = new ObjectSorter(new FooComparator);
	$fooTool->sort($array_of_foo_objects);


Procedural Interface
--------------------

There is also a procedural interface with functions much like sort, array_diff
and so on from the PHP core. This way the Comparable interface can be used in
a convenient, familiar way.

	osort($array_of_foo_objects);
	
Currently available:

	osort
	orsort
	oarsort
	oasort
	array_omultisort
	array_ounique
	array_odiff
	array_ointersect

For detailed description of the functions see phpDoc documentation inside 
functions.inc


Error Handling
--------------

You are encouraged to throw a ComparatorException if your compare() or compareTo()
methods fail, i.e. in case of wrong parameters. The tools will catch and handle
them.
By default most functions return false and trigger a E_USER_WARNING if such an
exception was thrown. But it is also possible to change this behaviour:

	ComparatorTool::setThrowExceptions(true);

so that the exceptions are carried on to your application.