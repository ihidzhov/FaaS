<?php 
namespace Ihidzhov\FaaS;

use Ihidzhov\FaaS\FaaS;
use Ihidzhov\FaaS\Config;
use Ihidzhov\FaaS\Func;
use Ihidzhov\FaaS\Log;
use Ihidzhov\FaaS\DB;
use Ihidzhov\FaaS\Schedule;

define("ROOT_DIR", dirname(__FILE__));
require_once './bootstrap.php';

$dbLambda = new DB(DB::SCHEMA_LAMBDA);
$dbLogs = new DB(DB::SCHEMA_LOGS);
$functions = new Func($dbLambda);

$config = new Config($dbLambda);
$configs = $config->get(Config::FUNCTIONS_KEY); 
$configs = Config::JSONToArray($configs["val"]);

FaaS::setConfigs($configs);

$schedule = new Schedule();

$functions = $functions->getScheduled(false);

if ($functions && is_array($functions)) {
    foreach($functions as $fn) {
        // Validate crontab
        $crontab = $schedule->crontabToArray($fn["trigger_details"]);
        $schedule->setSchedule($crontab);
        if ($schedule->isReadyToRun()) {
            $file = FUNCTIONS_DIR . $fn["hash"] . DIRECTORY_SEPARATOR . "index.php";
            if (file_exists($file)) {
                try {
                    require_once($file);
                    if (function_exists($fn["name"])) {
                        $fn["name"]();
                    }
                }   catch(Throwable $t) {
                    Log::toLambda($dbLogs, Log::LEVEL_ERROR, $fn["name"], $t->getMessage());
                } finally  {
                    Log::toLambda($dbLogs, Log::LEVEL_INFO, $fn["name"]);
                }
            }
        }
    }
} else {
    print("Error: Functions Not Found");
    exit;
}
