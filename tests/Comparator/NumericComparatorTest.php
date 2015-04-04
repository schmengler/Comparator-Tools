<?php
namespace SGH\Comparable\Test\Comparator;

use SGH\Comparable\Comparator\NumericComparator;
/**
 * NumericComparator test case.
 * 
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2015 SGH informationstechnologie UG
 * @license MIT
 * @link http://opensource.org/licenses/mit-license.php
 * @package Comparable
 * @since 1.1.0
 */
class NumericComparatorTest extends AbstractComparatorTest
{
    /**
     *
     * @var NumericComparator
     */
    private $numericComparator;

    /**
     * Tests NumericComparator->compare()
     * 
     * @test
     * @dataProvider dataNumeric
     */
    public function testCompare($number1, $number2, $expectedOrder)
    {
        $this->numericComparator = new NumericComparator();
        $actualOrder = $this->numericComparator->compare($number1, $number2);
        $this->assertCompareResult($expectedOrder, $actualOrder);
    }
    /**
     * Tests that non-scalar values passed to NumericComparator result in ComparatorException
     * 
     * @test
     * @dataProvider dataInvalidArguments
     * @expectedException \SGH\Comparable\ComparatorException
     * @param mixed $object1
     * @param mixed $object2
     */
    public function testInvalidArguments($object1, $object2)
    {
        $this->numericComparator = new NumericComparator();
        $this->numericComparator->compare($object1, $object2);
    }

    /**
     * Data provider for testCompare()
     * 
     * @return mixed[][]
     */
    public static function dataNumeric()
    {
        return array(
            'int_lt' => [1, 1, 0 ],
            'int_eq' => [2, 1, 1 ],
            'int_gt' => [1, 2, -1 ],
            'string_to_int' => ['010', '8', 1 ],
            'string_to_float' => ['0.5', '.55', -1 ],
            'float' => [0.0, 0.1, -1]
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