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

$app = new App();
$dbLambda = new DB(DB::SCHEMA_LAMBDA);
$page = new Page();
$functions = new Func($dbLambda);

// Web pages

$app->get(["dashboard",null], function() use($page) {
    $page->display("dashboard");
});
$app->get("funcs", function() use($page, $functions) {
    $data = $functions->prepareForListing($functions->getAll());
    $page->display("funcs",["title" => "Functions", "data" => $data]);
});
$app->get("func", function() use($page, $functions) {
    $id = $_REQUEST["id"] ?? null;
    $fn = [];
    if ($id) {
        $fn = $functions->get($id);
    }
    $page->display("func", [
        "triggers" => ["http" => Trigger::TRIGGER_HTTP, "time" => Trigger::TRIGGER_TIME],
        "id" => $id,
        "fn" => $fn,
        "host" => $functions->getHTTPHost(),
        "runtime" => ["list"=>Runtime::RT_ARRAY, "php" => Runtime::RT_PHP, "node" => Runtime::RT_NODE]
    ]);
});
$app->get("logs", function() use($page) {
    $page->display("logs");
});
$app->get("docs", function() use($page) {
    $page->display("docs");
});
 
// API 

$app->get("api-function-code", function() use($functions) {
    $fn = $functions->get((int)$_GET["id"]);
    $snippet = $functions->getCodeSnippet($fn); 
    echo json_encode(["snippet" => $snippet]);
});
$app->get("api-lambdas-xxx", function() use($functions) {
    $data = $functions->getAll();
    echo json_encode($data);exit;
});
$app->post("api-save-func", function() use($functions) {
    $code = $_REQUEST["editorContent"] ?? "";
    $code = (string)trim($code);
    $functionName = $_REQUEST["functionName"] ?? false;
    $triggerType = $_REQUEST["trigger"] ?? false;
    $triggerDetails = $_REQUEST["triggerDetails"] ?? "";
    $runtime = $_REQUEST["runtime"] ?? "";
    $id = $_REQUEST['id'] ?? false;
    
    if (!$code || !$functionName || !$triggerType || !$runtime) {
        echo json_encode(["status"=>"error","message"=>"Wrong request data"]);
        exit;
    }
    $response = [];
    if ($id) {
        if ($functions->update($id, $triggerType, $triggerDetails)) {
            $fn = $functions->get($id);
            if ($fn) {
                $functions->saveToFileSystem($fn["hash"], $runtime, $code);
                $response = ["status"=>"success","data"=>$fn];
            }
        }
    } else {
        $hash = $functions->generateHash($functionName);
        $id = $functions->insert($hash, $functionName, $triggerType, $triggerDetails, $runtime);
        if ($id) {
            $functions->saveToFileSystem($hash, $runtime, $code);
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

$app->run();
