<?php 

namespace Ihidzhov\FaaS;

use Exception;

class Runtime {

	const RT_PHP = 1;
	const RT_NODE = 2;

	const FILE_EXT = [
		self::RT_PHP => "php",
		self::RT_NODE => "js",
	];

	const RT_PHP_NAME = "PHP";
	const RT_NODE_NAME = "Node";

	const RT_ARRAY = [
		self::RT_PHP => self::RT_PHP_NAME,
		self::RT_NODE => self::RT_NODE_NAME,
	];

	public static function toFileExt($ext) {
		if (!isset(self::FILE_EXT[$ext])) {
			throw new Exception("No run time found");
		}
		return self::FILE_EXT[$ext];
	}
   
}
