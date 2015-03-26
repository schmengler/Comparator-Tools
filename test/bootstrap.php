<?php
require_once __DIR__ . '/../ComparatorTools/ComparatorTools.inc';

spl_autoload_register(function($class) {
	$file = str_replace('\\', '/', $class) . '.php';
	if (stream_resolve_include_path($file)) {
		include_once $file;
		return true;
	}
	return false;
});