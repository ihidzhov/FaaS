<?php 
namespace Ihidzhov\FaaS;

use Ihidzhov\FaaS\Config;
use Ihidzhov\FaaS\Func;
use Ihidzhov\FaaS\Trigger;
use Ihidzhov\FaaS\Log;
use Ihidzhov\FaaS\DB;
use Ihidzhov\FaaS\Request;
use Ihidzhov\FaaS\Runtime;

define("ROOT_DIR", dirname(__FILE__));
require_once __DIR__ . '/src/constants.php';
require_once __DIR__ . '/vendor/autoload.php';

$dbLambda = new DB(DB::SCHEMA_LAMBDA);
$functions = new Func($dbLambda);

if (!isset($_REQUEST["name"])) {
    print("Error: Not function name provided");
    exit;
}

$data = $functions->getByHash($_REQUEST["name"]);
if ($data) {
    $file = FUNCTIONS_DIR . $data["hash"] . DIRECTORY_SEPARATOR . "index." . Runtime::FILE_EXT[$data["runtime"]];
    if ($data["runtime"] == Runtime::RT_PHP) {
        if (file_exists($file)) {
            require_once($file);
            if (function_exists($data["name"])) {
                $data["name"]();
            }
        }
    } elseif ($data["runtime"] == Runtime::RT_NODE) {

    }
} else {
    print("Error: Function Not Found");
    exit;
}