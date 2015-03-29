<?php
namespace SGH\Comparable\Test\Comparator;

use SGH\Comparable\SetFunctions;
use SGH\Comparable\SortFunctions;
use SGH\Comparable\Test\ComparableValue;
use SGH\Comparable\Comparator\ComparableComparator;
use SGH\Comparable\Comparator\ObjectComparator;

/**
 * InvokableComparator test case
 */
class InvokableComparatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @dataProvider dataUnsortedArray
     * @param int[] $inputNumbers
     */
    public function testComparableComparatorCallback($inputNumbers)
    {
        $arrayWithCallback = $arrayWithSortTool = ComparableValue::getComparableObjects($inputNumbers);
        usort($arrayWithCallback, ComparableComparator::callback());
        SortFunctions::sort($arrayWithSortTool);
        $this->assertEquals($arrayWithSortTool, $arrayWithCallback);
    }
    /**
     * @test
     * @dataProvider dataObjectArrays
     * @param object[] $array1
     * @param object[] $array2
     */
    public function testObjectComparatorCallback($array1, $array2)
    {
        $diffWithCallback = array_udiff($array1, $array2, ObjectComparator::callback());
        $diffWithSortTool = SetFunctions::objectsDiff($array1, $array2);
    }
    /**
     * Data provider for testComparableComparatorCallback
     * 
     * @return int[][][]
     */
    public static function dataUnsortedArray()
    {
        return array(
        	[[2, 4, 1, 3, 5]]
        );
    }
    public static function dataObjectArrays()
    {
        $object1 = new \stdClass;
        $object2 = new \stdClass;
        $object3 = new \stdClass;
        return array(
        	[[$object1, $object2], [$object2, $object3]]
        );
    }
}