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
    public function testUnique()
    {
        // TODO Auto-generated SetFunctionsTest::testUnique()
        $this->markTestIncomplete("unique test not implemented");
        
        SetFunctions::unique(/* parameters */);
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

