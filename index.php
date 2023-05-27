<?php 
namespace Ihidzhov\FaaS;

use Ihidzhov\FaaS\Config;
use Ihidzhov\FaaS\Func;
use Ihidzhov\FaaS\Trigger;
use Ihidzhov\FaaS\Log;
use Ihidzhov\FaaS\DB;
use Ihidzhov\FaaS\Request;
use Ihidzhov\FaaS\Response;

define("ROOT_DIR", dirname(__FILE__));

require_once './bootstrap.php';


$app = new App();
$dbLambda = new DB(DB::SCHEMA_LAMBDA);
$dbLogs = new DB(DB::SCHEMA_LOGS);
$page = new Page();
$functions = new Func($dbLambda);
$config = new Config($dbLambda);

// Web pages

$app->get(["dashboard",null], function() use($page, $functions, $dbLogs) {
    $count = $functions->getCount();
    $latest = $functions->getMany(5)["rows"];
    $page->display("dashboard",[
        "count" => $count, 
        "latest" => $functions->prepareForListing($latest),
        "last_executed_functions" => Log::getMany($dbLogs, 0, 5),
        "navigation" => 1,
    ]);
});
$app->get("funcs", function() use($page, $functions) {
    $data = $functions->prepareForListing($functions->getAll());
    $page->display("funcs",[
        "title" => "Functions", 
        "data" => $data,
        "navigation" => 2,
    ]);
});
$app->get("func", function() use($page, $functions) {
    $id = $_REQUEST["id"] ?? null;
    $fn = [];
    if ($id) {
        $fn = $functions->get($id);
    }
    $page->display("func", [
        "triggers" => ["http" => Trigger::TRIGGER_HTTP, "time" => Trigger::TRIGGER_SCHEDULE],
        "id" => $id,
        "fn" => $fn,
        "host" => $functions->getHTTPHost(),
        "navigation" => 2,
    ]);
});
$app->get("logs", function() use($page, $dbLogs ) {
    $page->display("logs", ["navigation" => 3]);
});
$app->get("config", function() use($page) {
    $page->display("config", ["navigation" => 4]);
});
$app->get("docs", function() use($page) {
    $page->display("docs", ["navigation" => 6]);
});
 
// API 

$app->get("api-function-code", function() use($functions) {
    $fn = $functions->get((int)$_GET["id"]);
    $snippet = $functions->getCodeSnippet($fn); 
    echo json_encode(["snippet" => $snippet]);
});
$app->get("api-lambdas-table", function() use($functions) {
    $offset = $_REQUEST["offset"] ?? 0;
    $limit = $_REQUEST["limit"] ?? 10;
    $search = $_REQUEST["search"] ?? "";
    $data = $functions->getMany($offset, $limit, $search);
    echo json_encode($data);exit;
});
$app->get("api-logs-table", function() use($dbLogs) {
    $offset = $_REQUEST["offset"] ?? 0;
    $limit = $_REQUEST["limit"] ?? 10;
    $search = $_REQUEST["search"] ?? "";
    $data = Log::getMany($dbLogs, $offset, $limit, $search);
    Response::sentJSON($data);
});
$app->post("api-save-func", function() use($functions) {
    $code = $_REQUEST["editorContent"] ?? "";
    $code = (string)trim($code);
    $functionName = $_REQUEST["functionName"] ?? false;
    $triggerType = $_REQUEST["trigger"] ?? false;
    $triggerDetails = $_REQUEST["triggerDetails"] ?? "";
    $id = $_REQUEST['id'] ?? false;
    
    if (!$code || !$functionName || !$triggerType) {
        echo json_encode(["status"=>"error","message"=>"Wrong request data"]);
        exit;
    }
    $response = [];
    if ($id) {
        if ($functions->update($id, $triggerType, $triggerDetails)) {
            $fn = $functions->get($id);
            if ($fn) {
                $functions->saveToFileSystem($fn["hash"], $code);
                $response = ["status"=>"success","data"=>$fn];
            }
        }
    } else {
        $hash = $functions->generateHash($functionName);
        $id = $functions->insert($hash, $functionName, $triggerType, $triggerDetails);
        if ($id) {
            $functions->saveToFileSystem($hash, $code);
            $response = ["status"=>"success","data"=>["id"=>$id]];
        } else {
            $response = ["status"=>"error","message"=>"DB Error"];
        } 
    }
    echo json_encode($response);
    exit;
});
$app->delete("api-delete-func", function() use($functions) {
    $id = $_REQUEST['id'] ?? false;
    if (!$id) {
        echo json_encode(["status"=>"error","message"=>"ID requred"]);
        exit;
    }
    $response = [];
    $fn = $functions->get($id);
    if ($fn) {
        if ($functions->delete($id)) {
            $functions->removeFiles($fn["hash"]);
            $response = ["status"=>"success","data"=>$fn];
        }
    } else {
        $response = ["status"=>"error","message"=>"ID not found"];
    }
    echo json_encode($response);
    exit;
});
$app->put("api-update-config", function() use($config) {
    $response = ["status"=>"error","message"=>"Error! There is something wrong"];
    if ($config->update(Config::FUNCTIONS_KEY, trim(Request::getRawInput()))) {
        $response = ["status"=>"success","message"=>"Config was updated successfully"];
    }
    Response::sentJSON($response);
});
$app->get("api-config-code", function() use($config) {
    $cf = $config->get(Config::FUNCTIONS_KEY);
    $response = ["status"=>"error","message"=>"Error! There is something wrong"];
    if (is_array($cf) && isset($cf["val"])) {
        $response = ["status"=>"success","data"=>$cf["val"]];
    }
    Response::sentJSON($response);
});

$app->run();
