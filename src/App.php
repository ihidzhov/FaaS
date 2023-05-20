<?php 

namespace Ihidzhov\FaaS;

use Exception;

class App {
    
    private array $paths = [];

    public function get(array|string $path, $cb) :void {
        if (!is_callable($cb)) {
            $type = gettype($cb);
            throw new Exception("App::get(): Argument #2 ($cb) must be callable, {$type} given");
        }
        array_push($this->paths, [
            'path' => $path,
            'cb' => $cb
        ]);
    }

    public function post(array|string $path, $cb) :void {
        $this->get($path, $cb);
    }
    
    public function delete(array|string $path, $cb) :void {
        $this->get($path, $cb);
    }

    public function run() {
        $r = isset($_REQUEST['page']) ? trim(mb_strtolower($_REQUEST['page'])) : null;
        $cb = null;
        foreach($this->paths as $p) {
            if (is_array($p["path"])) {
                if (in_array($r, $p["path"])) {
                    $cb = $p["cb"];
                    break;
                }
            } else {
                if ($r == $p["path"]) {
                    $cb = $p["cb"];
                    break;
                }
            }
        }
        if (is_callable($cb)) {
            $cb();
        } else {
            throw new Exception("404");
        }
    }
}