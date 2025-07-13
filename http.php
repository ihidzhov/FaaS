<?php 
namespace Ihidzhov\FaaS;

use Ihidzhov\FaaS\FaaS;
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

$config = new Config($dbLambda);
$configs = $config->get(Config::FUNCTIONS_KEY); 
$configs = $configs ? Config::JSONToArray($configs["val"]) : [];

FaaS::setConfigs($configs);

$data = $functions->getByName($_REQUEST["name"]);
if ($data) {
    define("FUNCTION_NAME", $data["name"]);
    $function_dir = FUNCTIONS_DIR . DIRECTORY_SEPARATOR . $data["hash"];
    $file = $function_dir . DIRECTORY_SEPARATOR . "index.php";
    if (file_exists($file)) {
        // Eagerly load the Log class before we create the sandbox
        class_exists('Ihidzhov\FaaS\Log');

        $original_basedir = ini_get('open_basedir');
        $original_disabled_functions = ini_get('disable_functions');
        $original_max_execution_time = ini_get('max_execution_time');
        $original_memory_limit = ini_get('memory_limit');
        $error_message = null;

        try {
            // Apply STRICT restrictions
            ini_set('open_basedir', $function_dir);
            ini_set('max_execution_time', '5');
            ini_set('memory_limit', '32M');
            ini_set('disable_functions', 'exec,shell_exec,system,passthru,popen,proc_open');
            
            require_once($file);
            if (function_exists(FUNCTION_NAME)) {
                $functionName = FUNCTION_NAME;
                $functionName();
            }
        } catch(Throwable $t) {
            $error_message = $t->getMessage();
        } finally {
            // ALWAYS reset the restrictions, no matter what
            ini_set('open_basedir', $original_basedir);
            ini_set('max_execution_time', $original_max_execution_time);
            ini_set('memory_limit', $original_memory_limit);
            ini_set('disable_functions', $original_disabled_functions);
        }

        // Now that the sandbox is gone, do the logging
        if ($error_message) {
            Log::toLambda($dbLogs, Log::LEVEL_ERROR, FUNCTION_NAME, $error_message);
        }
        Log::toLambda($dbLogs, Log::LEVEL_INFO, FUNCTION_NAME);
    }
} else {
    print("Error: Function Not Found");
    exit;
}
