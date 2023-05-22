<?php 

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

define("DATABASE_DIR", ROOT_DIR . DIRECTORY_SEPARATOR . "database" . DIRECTORY_SEPARATOR);
define("TEMPLATES_DIR", ROOT_DIR . DIRECTORY_SEPARATOR . "templates" . DIRECTORY_SEPARATOR);
define("FUNCTIONS_DIR", ROOT_DIR . DIRECTORY_SEPARATOR . "fn" . DIRECTORY_SEPARATOR);

require_once __DIR__ . '/vendor/autoload.php';
