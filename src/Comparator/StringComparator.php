<?php
namespace SGH\Comparable\Comparator;

use SGH\Comparable\Comparator;
use SGH\Comparable\ComparatorException;

/**
 * Comparator for string comparison with strcmp(). Useful together with complex comparators
 * that need another comparator, like SGH\Comparable\Arrays\Comparator\KeyComparator.
 *
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2015 SGH informationstechnologie UG
 * @license MIT
 * @link http://opensource.org/licenses/mit-license.php
 * @package Comparable
 * @since 1.1.0
 */
class StringComparator implements Comparator
{
    /**
     * Comparison mode, defaults to STRCMP
     * 
     * @var StringCompareMode
     */
    private $compareMode;

    /**
     * Constructor
     * 
     * @param StringCompareMode $compareMode String comparison mode, defaults to STRCMP
     */
    public function __construct(StringCompareMode $compareMode = null)
    {
        if ($compareMode === null) {
            $compareMode = StringCompareMode::STRCMP();
        }
        $this->compareMode = $compareMode;
    }
    private static function isCastableToString($value)
    {
        if (is_scalar($value) || is_null($value)) {
            return true;
        }
        if (is_object($value) && method_exists($value, '__toString')) {
            return true;
        }
        return false;
    }
    /**
     * (non-PHPdoc)
     * 
     * @see \SGH\Comparable\Comparator::compare()
     */
    public function compare($object1, $object2)
    {
        if (! self::isCastableToString($object1)) {
            throw new ComparatorException('$object1 (type: ' . gettype($object1) . ') is not castable to string.');
        }
        if (! in_array(gettype($object2), ['string', 'integer', 'double'])) {
            throw new ComparatorException('$object2 (type: ' . gettype($object2) . ') is not castable to string.');
        }
        return call_user_func("\\{$this->compareMode}", $object1, $object2);
    }
    /**
     * Returns a callback object that can be used for core functions that take a callback parameter
     *
     * @return \SGH\Comparable\Comparator\InvokableComparator
     */
    public static function callback()
    {
        return new InvokableComparator(new static);
    }
}