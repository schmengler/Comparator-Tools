<?php
namespace SGH\Comparable;

require_once 'SGH/Comparable/SetFunctions.php';

require_once 'PHPUnit/Framework/TestCase.php';

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
        $actualDiff = SetFunctions::objectsDiff($array1, $array2, $array3);
        $this->assertEquals($expectedDiff, $actualDiff);
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
        $actualIntersect = SetFunctions::objectsIntersect($array1, $array2, $array3);
        $this->assertEquals($expectedIntersect, $actualIntersect);
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
        $actualUnique = SetFunctions::objectsUnique($array);
        $this->assertEquals($expectedUnique, array_values($actualUnique));
    }
    /**
     * Tests SetFunctions::diff()
     * 
     * @test
     * @dataProvider dataDifferentSets
     */
    public function testDiff()
    {
        $inputArrays = func_get_args();
        $inputObjects = array();
        foreach ($inputArrays as $inputNumbers) {
            $inputObjects[] = ComparableValue::getComparableObjects($inputNumbers);
        }

        call_user_func_array(array(get_class(new SetFunctions), 'diff'), $inputObjects);

        $expectedObjects = array();
        call_user_func_array('\array_diff', $inputArrays);
        foreach ($inputArrays as $expectedNumbers) {
            $expectedObjects[] = ComparableValue::getComparableObjects($expectedNumbers);
        }
        
        $this->assertEquals($expectedObjects, $inputObjects);
    }

    /**
     * Tests SetFunctions::intersect()
     * 
     * @test
     * @dataProvider dataDifferentSets
     */
    public function testIntersect()
    {
        $inputArrays = func_get_args();
        $inputObjects = array();
        foreach ($inputArrays as $inputNumbers) {
            $inputObjects[] = ComparableValue::getComparableObjects($inputNumbers);
        }

        call_user_func_array(array(get_class(new SetFunctions), 'intersect'), $inputObjects);

        $expectedObjects = array();
        call_user_func_array('\array_intersect', $inputArrays);
        foreach ($inputArrays as $expectedNumbers) {
            $expectedObjects[] = ComparableValue::getComparableObjects($expectedNumbers);
        }
        
        $this->assertEquals($expectedObjects, $inputObjects);
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
            [[1, 2, 3, 4], [1, 2], [4]]
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

