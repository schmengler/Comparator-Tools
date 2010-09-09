<?php
/**
 * Include this file to use the package
 * 
 * require 'functions.inc' at the bottom ist not mandatory and may be removed
 * 
 * @package ComparatorTools
 * @author Fabian Schmengler <fschmengler@sgh-it.eu>
 * @copyright &copy; 2010 SGH informationstechnologie UG
 * @license BSD
 * @link http://creativecommons.org/licenses/BSD/ 
 * @version 0.9
 */

if (version_compare(PHP_VERSION, '5.1', '<'))
	throw new Exception('The ComparatorTools package needs PHP 5.1 or higher.');

/**
 * Autoload function
 */
function autoload_comparatortools_lib($className) {
	$dirs = array(
		dirname(__FILE__),
		dirname(__FILE__) . '/Comparators',
		dirname(__FILE__) . '/Iterators'
	);
	foreach($dirs as $dir) {
		$filename = $dir . '/' . $className . '.php';
		if (file_exists($filename)) {
			require_once $filename;
			return true;
		}
	}
	return false;
}

spl_autoload_register('autoload_comparatortools_lib');

/*
 * if you do not want to use the procedural interface you can leave out this:
 */
require_once dirname(__FILE__) . '/functions.inc';