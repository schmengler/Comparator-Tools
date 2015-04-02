<?php
namespace SGH\Comparable\Test\Comparator;

use SGH\Comparable\Comparator\StringComparator;
use SGH\Comparable\Comparator\StringCompareMode;
/**
 * StringComparator test case.
 * 
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2015 SGH informationstechnologie UG
 * @license MIT
 * @link http://opensource.org/licenses/mit-license.php
 * @package Comparable
 * @since 1.1.0
 */
class StringComparatorTest extends AbstractComparatorTest
{
    /**
     *
     * @var StringComparator
     */
    private $stringComparator;

    /**
     * Tests StringComparator->compare()
     * 
     * @test
     * @dataProvider dataString
     */
    public function testCompare($mode, $number1, $number2, $expectedOrder)
    {
        $this->stringComparator = new StringComparator($mode);
        $actualOrder = $this->stringComparator->compare($number1, $number2);
        $this->assertCompareResult($expectedOrder, $actualOrder);
    }
    /**
     * Tests that non-scalar values passed to StringComparator result in ComparatorException
     * 
     * @test
     * @dataProvider dataInvalidArguments
     * @expectedException \SGH\Comparable\ComparatorException
     * @param mixed $object1
     * @param mixed $object2
     */
    public function testInvalidArguments($object1, $object2)
    {
        $this->stringComparator = new StringComparator();
        $this->stringComparator->compare($object1, $object2);
    }

    /**
     * Data provider for testCompare()
     * 
     * @return mixed[][]
     */
    public static function dataString()
    {
        return array(
            [ StringCompareMode::STRCMP(), 'ab', 'ab', 0 ],
            [ StringCompareMode::STRCMP(), 'aab', 'abb', -1 ],
            [ StringCompareMode::STRCMP(), 'abb', 'aab', 1 ],
            [ StringCompareMode::STRCMP(), 'abb', 'ab', 1 ],
            [ StringCompareMode::STRCMP(), 'a', 'A', 1 ],
            [ StringCompareMode::STRCMP(), 'AAB', 'abb', -1 ],
            [ StringCompareMode::STRCMP(), 'abb', 'AAB', 1 ],
            [ StringCompareMode::STRCMP(), 'file2', 'file10', 1 ],
            [ StringCompareMode::STRCMP(), 'FILE2', 'file10', -1 ],
            
            [ StringCompareMode::STRCASECMP(), 'ab', 'ab', 0 ],
            [ StringCompareMode::STRCASECMP(), 'aab', 'abb', -1 ],
            [ StringCompareMode::STRCASECMP(), 'abb', 'aab', 1 ],
            [ StringCompareMode::STRCASECMP(), 'abb', 'ab', 1 ],
            [ StringCompareMode::STRCASECMP(), 'A', 'a', 0 ],
            [ StringCompareMode::STRCASECMP(), 'AAB', 'abb', -1 ],
            [ StringCompareMode::STRCASECMP(), 'abb', 'AAB', 1 ],
            [ StringCompareMode::STRCASECMP(), 'file2', 'file10', 1 ],
            [ StringCompareMode::STRCASECMP(), 'FILE2', 'file10', 1 ],
            
            [ StringCompareMode::STRNATCMP(), 'ab', 'ab', 0 ],
            [ StringCompareMode::STRNATCMP(), 'aab', 'abb', -1 ],
            [ StringCompareMode::STRNATCMP(), 'abb', 'aab', 1 ],
            [ StringCompareMode::STRNATCMP(), 'abb', 'ab', 1 ],
            [ StringCompareMode::STRNATCMP(), 'a', 'A', 1 ],
            [ StringCompareMode::STRNATCMP(), 'AAB', 'abb', -1 ],
            [ StringCompareMode::STRNATCMP(), 'abb', 'AAB', 1 ],
            [ StringCompareMode::STRNATCMP(), 'file2', 'file10', -1 ],
            [ StringCompareMode::STRNATCMP(), 'FILE2', 'file10', -1 ],
            
            [ StringCompareMode::STRNATCASECMP(), 'ab', 'ab', 0 ],
            [ StringCompareMode::STRNATCASECMP(), 'aab', 'abb', -1 ],
            [ StringCompareMode::STRNATCASECMP(), 'abb', 'aab', 1 ],
            [ StringCompareMode::STRNATCASECMP(), 'abb', 'ab', 1 ],
            [ StringCompareMode::STRNATCASECMP(), 'A', 'a', 0 ],
            [ StringCompareMode::STRNATCASECMP(), 'AAB', 'abb', -1 ],
            [ StringCompareMode::STRNATCASECMP(), 'abb', 'AAB', 1 ],
            [ StringCompareMode::STRNATCASECMP(), 'file2', 'file10', -1 ],
            [ StringCompareMode::STRNATCASECMP(), 'FILE2', 'file10', -1 ],
            
        );
    }
    /**
     * Data provider for testInvalidArguments()
     * 
     * @return mixed[][]
     */
    public static function dataInvalidArguments()
    {
        return array(
        	[new \stdClass, 1],
            [1, new \stdClass],
            [array(), 1],
            [1, array()]
        );
    }
}