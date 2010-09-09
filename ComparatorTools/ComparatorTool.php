<?php
/**
 * Base class of comparator tools
 * 
 * @see ObjectSorter
 * @see ObjectArrayModifier
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2010 SGH informationstechnologie UG
 * @license BSD
 * @link http://creativecommons.org/licenses/BSD/ 
 * @package ComparatorTools
 * @version 0.9
 */
abstract class ComparatorTool
{
	private static $throwExceptions = false;
	
	private $comparator;
	
	/**
	 * ComparatorTool constructor
	 * 
	 * @param Comparator|null $comparator Comparator to be used (default ComparableComparator if $comparator is null)
	 */
	final public function __construct(Comparator $comparator = null)
	{
		$this->setComparator($comparator);
	}
	
	/**
	 * @return Comparator the $comparator
	 */
	public function getComparator() {
		return $this->comparator;
	}

	/**
	 * Sets $comparator (default ComparableComparator if $comparator is null)
	 * 
	 * @param Comparator|null $comparator the $comparator to set
	 * @return ComparatorTool
	 */
	public function setComparator(Comparator $comparator = null) {
		if ($comparator === null) {
			$comparator = new ComparableComparator();
		}
		$this->comparator = $comparator;
		return $this;
	}

	/**
	 * @return boolean the $throwExceptions
	 */
	public static function getThrowExceptions()
	{
		return self::$throwExceptions;
	}

	/**
	 * @param boolean $throwExceptions the $throwExceptions to set
	 * @return ComparatorTool
	 */
	public static function setThrowExceptions($throwExceptions)
	{
		self::$throwExceptions = (bool) $throwExceptions;
	}

	/**
	 * Throws Exception or triggers E_USER_WARNING, dependant on $throwExceptions property.
	 * 
	 * @param ComparatorException $e
	 * @param string $method
	 * @return false
	 * @throws ComparatorException if $throwExceptions is set to TRUE
	 */
	protected function handleException(ComparatorException $e, $method)
	{
		$trace = $e->getTrace();
		$last = reset($trace);
		$position = (isset($last['class']) ? $last['class'] . '::' : '') . $last['function'];
		$message = $method . ' failed. Exception in ' . $position . ' with message: ' . $e->getMessage();
		if (self::$throwExceptions) {
			throw new ComparatorException($message, $e->getCode());
		} else {
			trigger_error($message, E_USER_WARNING);
			return false;
		}
	}
}