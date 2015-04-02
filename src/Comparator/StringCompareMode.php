<?php
namespace SGH\Comparable\Comparator;

/**
 * StringCompareMode Enum, defines compare modes for StringComparator
 * 
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2015 SGH informationstechnologie UG
 * @license MIT
 * @link http://opensource.org/licenses/mit-license.php
 * @package Comparable
 * @since 1.1.0
 */
final class StringCompareMode
{
    private $value;

    private static $instances = [];
    
    private final function __construct($value)
    {
        $this->value = (string) $value;
    }
    
    private final function __clone() { }
    
    private static function fromString($value)
    {
        if (!isset(self::$instances[(string)$value])) {
            self::$instances[(string)$value] = new static($value);
        }
        return self::$instances[(string)$value];
    }
    /**
     * Returns string represantation of enum. This is the name of the corresponding PHP function
     * 
     * @return string
     */
    public function __toString()
    {
        return strtolower($this->value);
    }
    /**
     * Case insensitive binary-safe string comparison with strcasecmp()
     * 
     * @return \SGH\Comparable\Comparator\CompareMode
     */
    public static function STRCASECMP()
    {
        return self::fromString(__FUNCTION__);
    }
    /**
     * Binary-safe string comparison with strcmp()
     * 
     * @return \SGH\Comparable\Comparator\CompareMode
     */
    public static function STRCMP()
    {
        return self::fromString(__FUNCTION__);
    }
    /**
     * "Natural order" string comparison with strnatcmp()
     * 
     * @return \SGH\Comparable\Comparator\CompareMode
     */
    public static function STRNATCMP()
    {
        return self::fromString(__FUNCTION__);
    }
    /**
     * Case insensitive "natural order" string comparison with strnatcasecmp()
     * 
     * @return \SGH\Comparable\Comparator\CompareMode
     */
    public static function STRNATCASECMP()
    {
        return self::fromString(__FUNCTION__);
    }
}