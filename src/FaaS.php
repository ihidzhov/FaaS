<?php 

namespace Ihidzhov\FaaS;

class FaaS {

    private static array $configs = [];


    public static function getConfigs() :array {
        return self::$configs;
    }

    public static function setConfigs(array $configs) :void {
        self::$configs = $configs;
    }
  
}
