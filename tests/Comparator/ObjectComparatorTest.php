<?php
namespace SGH\Comparable\Comparator;

use SGH\Comparable\SetFunctions;

/**
 * ObjectComparator test case
 */
class ObjectComparatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests SetFunctions::diff() with ObjectComparator
     *
     * @test
     */
    public function testDiff()
    {
        $same1 = $same2 = new \stdClass;
        $different1 = new \stdClass;
        $different2 = new \stdClass;

        $actualDiff = SetFunctions::diff([$same1, $different1], [$same2, $different2], new ObjectComparator);
        $expectedDiff = [ 1 => $different1 ];
        $this->assertEquals($expectedDiff, $actualDiff);
    }
    /**
     * Tests SetFunctions::intersect() with ObjectComparator
     * 
     * @test
     */
    public function testIntersect()
    {
        $same1 = $same2 = new \stdClass;
        $different1 = new \stdClass;
        $different2 = new \stdClass;

        $actualDiff = SetFunctions::intersect([$different1, $same1], [$same2, $different2], new ObjectComparator);
        $expectedDiff = [ 1 => $same1 ];
        $this->assertEquals($expectedDiff, $actualDiff);
    }
    /**
     * Tests SetFunctions::unique() with ObjectComparator
     * 
     * @test
     */
    public function testUnique()
    {
        $same1 = $same2 = new \stdClass;
        $different1 = new \stdClass;
        $different2 = new \stdClass;

        $actualUnique = SetFunctions::unique([$different1, $same1, $same2, $different2], new ObjectComparator);
        ksort($actualUnique); // sort order from spl_object_hash is not deterministic
        $expectedUnique = [ $different1, $same1, $different2 ];
        $this->assertEquals($expectedUnique, array_values($actualUnique));
    }
    /**
     * Tests that non-objects passed to ObjectComparator result in ComparatorException
     * 
     * @test
     * @dataProvider dataInvalidArguments
     * @expectedException \SGH\Comparable\ComparatorException
     * @param mixed $object1
     * @param mixed $object2
     */
    public function testInvalidArguments($object1, $object2)
    {
        $objectComparator = new ObjectComparator();
        $objectComparator->compare($object1, $object2);
    }
    /**
     * Data provider for testInvalidArguments()
     * 
     * @return mixed[][]
     */
    public static function dataInvalidArguments()
    {
        return array(
        	[new \stdClass, 'foo'],
            ['foo', new \stdClass],
            ['foo', 'bar']
        );
    }
}