<?php
namespace SGH\Comparable\Test\Comparator;

abstract class AbstractComparatorTest extends \PHPUnit_Framework_TestCase
{
    protected function assertCompareResult($expectedOrder, $actualOrder)
    {
        $this->assertInternalType('int', $actualOrder);
        if ($expectedOrder > 0) {
            $this->assertGreaterThan(0, $actualOrder);
        } elseif ($expectedOrder < 0) {
            $this->assertLessThan(0, $actualOrder);
        } else {
            $this->assertEquals(0, $actualOrder);
        }
    }
}