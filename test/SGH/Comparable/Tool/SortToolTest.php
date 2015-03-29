<?php
namespace SGH\Comparable\Tool;

use SGH\Comparable\Comparator\ObjectComparator;
use SGH\Comparable\ComparableValue;
require_once 'SGH/Comparable/Tool/SortTool.php';

require_once 'PHPUnit/Framework/TestCase.php';

/**
 * SortTool test case.
 */
class SortToolTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var SortTool
     */
    private $sortTool;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp()
    {
        parent::setUp();
        
        $this->sortTool = new SortTool();
    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown()
    {
        $this->sortTool = null;
        
        parent::tearDown();
    }
    /**
     * Tests that reverting default comparator adds the ReverseComparator decorator
     * 
     * @test
     */
    public function testReverseDefault()
    {
        $actualReverseComparator = $this->sortTool->reverse()->getComparator();
        $this->assertInstanceOf('\SGH\Comparable\Comparator\ReverseComparator', $actualReverseComparator);
        $this->assertInstanceOf('\SGH\Comparable\Comparator\ComparableComparator', $actualReverseComparator->getOriginalComparator());
    }
    /**
     * Tests that reverting specific comparator adds the ReverseComparator decorator
     * 
     * @test
     */
    public function testReverseSpecified()
    {
        $actualReverseComparator = $this->sortTool->setComparator(new ObjectComparator)->reverse()->getComparator();
        $this->assertInstanceOf('\SGH\Comparable\Comparator\ReverseComparator', $actualReverseComparator);
        $this->assertInstanceOf('\SGH\Comparable\Comparator\ObjectComparator', $actualReverseComparator->getOriginalComparator());
    }
    /**
     * Tests that reverting sort order twice removes the ReverseComparator decorator
     * 
     * @test
     */
    public function testReverseReverse()
    {
        $actualReverseComparator = $this->sortTool->reverse()->reverse()->getComparator();
        $this->assertInstanceOf('\SGH\Comparable\Comparator\ComparableComparator', $actualReverseComparator);
    }
    /**
     * Tests that setting a different comparator after applying reverse order, removes the reverse
     * 
     * @test
     */
    public function testOverrideReverse()
    {
        $actualReverseComparator = $this->sortTool->reverse()->setComparator(new ObjectComparator)->getComparator();
        $this->assertInstanceOf('\SGH\Comparable\Comparator\ObjectComparator', $actualReverseComparator);
    }
    /**
     * Tests that reverse sort order works correctly on all arrays with multisort()
     * 
     * @test
     */
    public function testMultisortReverse()
    {
        $objectArray = ComparableValue::getComparableObjects([2, 1, 3]);
        $arbitraryArrayNumericKeys = ['two', 'one', 'three'];
        $arbitraryArrayAssociative = ['two' => 'two', 'one' => 'one', 'three' => 'three'];
        $expectedObjectArray = ComparableValue::getComparableObjects([2 => 3, 0 => 2, 1 => 1]);
        $expectedArbitraryArrayNumericKeys = ['three', 'two', 'one'];
        $expectedArbitraryArrayAssociative = ['three' => 'three', 'two' => 'two', 'one' => 'one'];
        
        $this->sortTool->reverse()->multisort(array(&$objectArray, &$arbitraryArrayNumericKeys, &$arbitraryArrayAssociative));

        $this->assertEquals($expectedObjectArray, $objectArray);
        $this->assertEquals($expectedArbitraryArrayNumericKeys, $arbitraryArrayNumericKeys);
        $this->assertEquals($expectedArbitraryArrayAssociative, $arbitraryArrayAssociative);
    }
    /**
     * Tests that multisort() throws \InvalidArgumentException if argument is not an array of arrays of the same size
     * 
     * @test
     * @dataProvider invalidMultisortArguments
     * @expectedException \InvalidArgumentException
     * @param array $arrays
     */
    public function testMultisortInvalidArguments($arrays)
    {
        $this->sortTool->multisort($arrays);
    }
    /**
     * Data provider for testMultisortInvalidArguments()
     * 
     * @return array[][]
     */
    public static function invalidMultisortArguments()
    {
        return array(
        	'first_not_an_array' => [['string']],
        	'second_not_an_array' => [[array(1), SORT_ASC]],
            'different_sizes' => [[array(1, 2), array(1)]],
            
        );
    }
}

