<?php 
namespace Ihidzhov\FaaS;

use Ihidzhov\FaaS\Trigger;

class HTML {

    const NAVIGATION = [
        [
            "id" => 1,
            "slug" => "dashboard",
            "name" => "Dashboard",
        ],
        [
            "id" => 2,
            "slug" => "funcs",
            "name" => "Functions",
        ],
        [
            "id" => 3,
            "slug" => "logs",
            "name" => "Logs",
        ],
        [
            "id" => 4,
            "slug" => "config",
            "name" => "Config",
        ],
        [
            "id" => 5,
            "slug" => "settings",
            "name" => "User preferences",
        ],
        [
            "id" => 6,
            "slug" => "docs",
            "name" => "Docs",
        ],
    ];
    
    public static function buildNavigation(int $current) :array {
        $navigation = self::NAVIGATION;
        foreach($navigation as $key => $nav) {
            if ($current === $nav["id"]) {
                $navigation[$key]["active"] = true;
            }
        }
        return $navigation;
    }


}
