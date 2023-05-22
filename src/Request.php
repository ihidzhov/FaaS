<?php 

namespace Ihidzhov\FaaS;

class Request {
  
    const METHOD_GET = "GET";
    const METHOD_POST = "POST";
    const METHOD_PUT = "PUT";
    const METHOD_DELETE = "ELETE";

    public static function isGET() {
        $_SERVER['REQUEST_METHOD'] == self::METHOD_GET;
    }

    public static function isPOST() {
        $_SERVER['REQUEST_METHOD'] == self::METHOD_POST;
    }

    public static function isPUT() {
        $_SERVER['REQUEST_METHOD'] == self::METHOD_PUT;
    }

    public static function isDELETE() {
        $_SERVER['REQUEST_METHOD'] == self::METHOD_DELETE;
    }

    public static function getRawInput() {
        return file_get_contents("php://input");
	}

    public static function parseInput() {
        $data = self::getRawInput();
		if($data == false)
			return array();

		parse_str($data, $result);

		return $result;
	}

    public static function sentJSON($data) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
        exit;
    }

}