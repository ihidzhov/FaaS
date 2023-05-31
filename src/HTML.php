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
            "slug" => "preferences",
            "name" => "User preferences",
        ],
        [
            "id" => 6,
            "slug" => "docs",
            "name" => "Docs",
        ],
    ];

    const SITE_THEMES = [
        1 => "Cyborg",
        2 => "Darkly",
        3 => "Litera",
        4 => "Solar",
        5 => "Superhero",
        6 => "Yeti",
        7 => "Quartz",
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

    public static function buildSiteThemes($userTheme = false) {
        $themes = [];
        foreach(self::SITE_THEMES as $key => $theme) {
            $t = ["id" => $key, "name" => $theme];
            if ($userTheme == $key) {
                $t["selected"] = true;
            }
            $themes[$key] = $t;
        }
        return $themes;
    }


}
