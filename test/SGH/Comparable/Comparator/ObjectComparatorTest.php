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

        $actualDiff = SetFunctions::withComparator(new ObjectComparator())->diff([$same1, $different1], [$same2, $different2]);
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

        $actualDiff = SetFunctions::withComparator(new ObjectComparator())->intersect([$different1, $same1], [$same2, $different2]);
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

        $actualUnique = SetFunctions::withComparator(new ObjectComparator())->unique([$different1, $same1, $same2, $different2]);
        ksort($actualUnique); // sort order from spl_object_hash is not deterministic
        $expectedUnique = [ $different1, $same1, $different2 ];
        $this->assertEquals($expectedUnique, array_values($actualUnique));
    }
}