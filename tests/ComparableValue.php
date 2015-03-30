<?php
namespace SGH\Comparable\Test;

use SGH\Comparable\Comparable;
use SGH\Comparable\ComparatorException;
/**
 * A Simple Comparable implementation as value object that allows testing against core methods.
 * 
 * Instances contains an integer property that the compareTo method refers to
 */
class ComparableValue implements Comparable
{

    private static $instances = array();

    public static function getInstance($value)
    {
        if (! isset(self::$instances[$value])) {
            self::$instances[$value] = new static($value);
        }
        return self::$instances[$value];
    }

    /**
     * Generates comparable test objects from numbers
     *
     * @param int[] $numbers
     * @return ComparableValue[]
     */
    public static function getComparableObjects($numbers)
    {
        $objects = array();
        foreach ($numbers as $order => $number) {
            $objects['key_' . $number . '_' . $order] = ComparableValue::getInstance($number);
        }
        return $objects;
    }
    
    /*
     * @var int
    */
    private $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function compareTo($object)
    {
        if (! $object instanceof ComparableValue)
            throw new ComparatorException('object is not of type ComparableValue');
        return $this->value - $object->value;
    }
}