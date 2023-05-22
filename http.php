<?php 
namespace Ihidzhov\FaaS;

use Ihidzhov\FaaS\Config;
use Ihidzhov\FaaS\Func;
use Ihidzhov\FaaS\Log;
use Ihidzhov\FaaS\DB;

define("ROOT_DIR", dirname(__FILE__));
require_once './bootstrap.php';

$dbLambda = new DB(DB::SCHEMA_LAMBDA);
$dbLogs = new DB(DB::SCHEMA_LOGS);
$functions = new Func($dbLambda);

if (!isset($_REQUEST["name"])) {
    print("Error: Not function name provided");
    exit;
}

$data = $functions->getByName($_REQUEST["name"]);
if ($data) {
    $file = FUNCTIONS_DIR . $data["hash"] . DIRECTORY_SEPARATOR . "index.php";
    if (file_exists($file)) {
        try {
            require_once($file);
            if (function_exists($data["name"])) {
                $data["name"]();
            }
        }   catch(Throwable $t) {
            Log::toLambda($dbLogs, Log::LEVEL_ERROR, $data["name"], $t->getMessage());
        } finally  {
            Log::toLambda($dbLogs, Log::LEVEL_INFO, $data["name"]);
        }
    }
} else {
    print("Error: Function Not Found");
    exit;
}