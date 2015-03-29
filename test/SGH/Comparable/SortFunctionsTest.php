<?php
namespace SGH\Comparable;

require_once 'src/SGH/Comparable/SortFunctions.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * SortFunctions test case.
 */
class SortFunctionsTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Tests SortFunctions::sort()
     *
     * @test
     * @dataProvider dataUnsortedArrays
     */
    public function testSort($inputNumbers)
    {
        $inputObjects = ComparableValue::getComparableObjects($inputNumbers);
        sort($inputNumbers);
        $expectedObjects = array_values(ComparableValue::getComparableObjects($inputNumbers));
        SortFunctions::sort($inputObjects);
        $this->assertEquals($expectedObjects, $inputObjects);
    }

    /**
     * Tests SortFunctions::asort()
     *
     * @test
     * @dataProvider dataUnsortedArrays
     */
    public function testAsort($inputNumbers)
    {
        $inputObjects = ComparableValue::getComparableObjects($inputNumbers);
        asort($inputNumbers);
        $expectedObjects = ComparableValue::getComparableObjects($inputNumbers);
        SortFunctions::asort($inputObjects);
        $this->assertEquals($expectedObjects, $inputObjects);
    }

    /**
     * Tests SortFunctions::rsort()
     *
     * @test
     * @dataProvider dataUnsortedArrays
     */
    public function testRsort($inputNumbers)
    {
        $inputObjects = ComparableValue::getComparableObjects($inputNumbers);
        rsort($inputNumbers);
        $expectedObjects = array_values(ComparableValue::getComparableObjects($inputNumbers));
        SortFunctions::rsort($inputObjects);
        $this->assertEquals($expectedObjects, $inputObjects);
    }

    /**
     * Tests SortFunctions::arsort()
     *
     * @test
     * @dataProvider dataUnsortedArrays
     */
    public function testArsort($inputNumbers)
    {
        $inputObjects = ComparableValue::getComparableObjects($inputNumbers);
        arsort($inputNumbers);
        $expectedObjects = ComparableValue::getComparableObjects($inputNumbers);
        SortFunctions::arsort($inputObjects);
        $this->assertEquals($expectedObjects, $inputObjects);
    }

    /**
     * Tests SortFunctions::multisort()
     * 
     * @test
     */
    public function testMultisort()
    {
        $inputReferenceArray = ComparableValue::getComparableObjects(array(1, 0, 2, - 1, 0));
        $inputSecondArray = array('one', 'zero', 'two', 'minus one', 'zero(2)');
        $arrays = array(
            &$inputReferenceArray,
            &$inputSecondArray
        );
        SortFunctions::multisort($arrays);
        $this->assertEquals(ComparableValue::getComparableObjects(array(
            3 => - 1, 1 => 0, 4 => 0, 0 => 1, 2 => 2
        )), $inputReferenceArray, 'Reference array.');
        $this->assertEquals(array(
            'minus one', 'zero', 'zero(2)', 'one', 'two'
        ), $inputSecondArray, 'Second array.');
    }

    /**
     * @test
     * @dataProvider dataInvalidSortArguments
     * @expectedException \SGH\Comparable\ComparatorException
     */
    public function testInvalidSortArguments($inputObjects)
    {
        SortFunctions::sort($inputObjects);
    }
    /**
     * Data provider
     * 
     * @return int[][][]
     */
    public static function dataUnsortedArrays()
    {
        return array(
            [[4, 5, 3, 1, 2]],
            [[1, 4, 3, 2, 5]],
            [[1, 2, 3, 4, 5]],
            [[5, 4, 3, 2, 1]],
            [[2, 1, 2, 1]],
            [[-1, 1, 0]]
        );
    }
    public static function dataInvalidSortArguments()
    {
        return array(
        	'comparable_and_other_object' => [[ComparableValue::getInstance(1), new \stdClass]],
        	'other_object_and_comparable' => [[new \stdClass, ComparableValue::getInstance(1)]],
            'comparable_and_string'       => [[ComparableValue::getInstance(1), 'foo']],
            'only_other_objects'          => [[new \stdClass, new \stdClass]],
            'only_strings'                => [['foo', 'bar']]                        
        );
    }
}
