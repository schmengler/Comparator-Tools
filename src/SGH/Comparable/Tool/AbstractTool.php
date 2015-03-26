<?php
namespace SGH\Comparable\Tool;

use SGH\Comparable\Comparator;
use SGH\Comparable\Comparator\ComparableComparator;

abstract class AbstractTool
{

    private $comparator;

    /**
     * ComparatorTool constructor
     *
     * @param Comparator|null $comparator
     *            Comparator to be used (default ComparableComparator if $comparator is null)
     */
    final public function __construct(Comparator $comparator = null)
    {
        $this->setComparator($comparator);
    }

    /**
     *
     * @return Comparator the $comparator
     */
    public function getComparator()
    {
        return $this->comparator;
    }

    /**
     * Sets $comparator (default ComparableComparator if $comparator is null)
     *
     * @param Comparator|null $comparator
     *            the $comparator to set
     * @return ComparatorTool
     */
    public function setComparator(Comparator $comparator = null)
    {
        if ($comparator === null) {
            $comparator = new ComparableComparator();
        }
        $this->comparator = $comparator;
        return $this;
    }
}
