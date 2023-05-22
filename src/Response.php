<?php 

namespace Ihidzhov\FaaS;

class Response {
    
    public static function sentJSON(array $data, bool $pretty = false) :never {
        header('Content-Type: application/json; charset=utf-8');
        if ($pretty) {
            echo json_encode($data, JSON_PRETTY_PRINT);
        } else {
            echo json_encode($data);
        }
        exit;
    }

}