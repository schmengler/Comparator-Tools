<?php
namespace SGH\Comparable\Test;

use SGH\Comparable\Comparator\ObjectComparator;
use SGH\Comparable\SetFunctions;

/**
 * SetFunctions test case.
 */
class SetFunctionsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests SetFunctions::objectsDiff()
     */
    public function testObjectsDiff()
    {
        $object1 = new \stdClass;
        $object2 = new \stdClass;
        $object3 = new \stdClass;
        $array1 = array($object1, $object2, $object3);
        $array2 = array($object2, $object2);
        $array3 = array($object3);

        $expectedDiff = array($object1);
        $this->assertEquals($expectedDiff, SetFunctions::objectsDiff($array1, $array2, $array3));
        $this->assertEquals($expectedDiff, SetFunctions::diff($array1, $array2, $array3, new ObjectComparator));
    }
    /**
     * Tests SetFunctions::objectsIntersect()
     */
    public function testObjectsIntersect()
    {
        $object1 = new \stdClass;
        $object2 = new \stdClass;
        $object3 = new \stdClass;
        $array1 = array($object1, $object2, $object3);
        $array2 = array($object2, $object2);
        $array3 = array($object2, $object3);

        $expectedIntersect = array(1 => $object2);
        $this->assertEquals($expectedIntersect, SetFunctions::objectsIntersect($array1, $array2, $array3));
        $this->assertEquals($expectedIntersect, SetFunctions::intersect($array1, $array2, $array3, new ObjectComparator));
    }
    /**
     * Tests SetFunctions::objectsUnique()
     */
    public function testObjectsUnique()
    {
        $object1 = new \stdClass;
        $object2 = new \stdClass;
        $array = array($object1, $object2, $object2);
        
        $expectedUnique = array($object1, $object2);
        $this->assertEquals($expectedUnique, array_values(SetFunctions::objectsUnique($array)));
        $this->assertEquals($expectedUnique, array_values(SetFunctions::unique($array, new ObjectComparator)));
    }
    /**
     * Tests SetFunctions::diff()
     * 
     * @test
     * @dataProvider dataDifferentSets
     */
    public function testDiff()
    {
        $this->_testAgainstCoreFunction('diff', '\array_diff', func_get_args());
    }

    /**
     * Tests SetFunctions::intersect()
     * 
     * @test
     * @dataProvider dataDifferentSets
     */
    public function testIntersect()
    {
        $this->_testAgainstCoreFunction('intersect', '\array_intersect', func_get_args());
    }
        
    /**
     * Tests SetFunctions::diffAssoc()
     * 
     * @test
     * @dataProvider dataDifferentSets
     */
    public function testDiffAssoc()
    {
        $this->_testAgainstCoreFunction('diff_assoc', '\array_diff_assoc', func_get_args());
    }

    /**
     * Tests SetFunctions::intersectAssoc()
     * 
     * @test
     * @dataProvider dataDifferentSets
     */
    public function testIntersectAssoc()
    {
        $this->_testAgainstCoreFunction('intersect_assoc', '\array_intersect_assoc', func_get_args());
    }
    
    /**
     * Tests SetFunctions::unique()
     * 
     * @test
     * @dataProvider dataDuplicates
     */
    public function testUnique($inputNumbers)
    {
        $inputObjects = ComparableValue::getComparableObjects($inputNumbers);
        $expectedNumbers = array_unique($inputNumbers);
        $expectedObjects = ComparableValue::getComparableObjects($expectedNumbers);
        $actualObjects = SetFunctions::unique($inputObjects);
        $this->assertEquals(array_values($expectedObjects), array_values($actualObjects));
    }

	/**
     * @param methodUnderTest
     * @param coreFunction
     * @param inputArrays
     */
    private function _testAgainstCoreFunction($methodUnderTest, $coreFunction, $inputArrays)
    {
        $inputObjects = array();
        foreach ($inputArrays as $inputNumbers) {
            $inputObjects[] = ComparableValue::getComparableObjects($inputNumbers);
        }

        $actualObjects = call_user_func_array(array(get_class(new SetFunctions), $methodUnderTest), $inputObjects);

        $expectedNumbers = call_user_func_array($coreFunction, $inputArrays);
        $expectedObjects = ComparableValue::getComparableObjects($expectedNumbers);
        $this->assertEquals($expectedObjects, $actualObjects);
    }
    
    /**
     * Data provider
     * 
     * @return int[][][]
     */
    public static function dataDifferentSets()
    {
        return array(
            [[1, 2, 3, 4], [1, 2, 3]],
            [[1, 2, 3], [1, 2, 3, 4]],
            [[1, 2, 3], [2, 3, 4]],
            [[1, 2, 3, 4], [1, 2], [4]],
            'different_string_keys' => [['a' => 1, 'b' => 2], ['a' => 1, 'c' => 2]]
        );
    }
    /**
     * Data provider
     * 
     * @return int[][][]
     */
    public static function dataDuplicates()
    {
        return array(
        	[[1, 2, 3]],
        	[[1, 1, 2]],
            [[1, 2, 1]],
            [[1, 1, 1]],
        );
    }
}

