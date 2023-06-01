<?php 
namespace Ihidzhov\FaaS;

use Ihidzhov\FaaS\Trigger;
use Ihidzhov\FaaS\Preferences;

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
 
    public static function buildNavigation(int $current) :array {
        $navigation = self::NAVIGATION;
        foreach($navigation as $key => $nav) {
            if ($current === $nav["id"]) {
                $navigation[$key]["active"] = true;
            }
        }
        return $navigation;
    }

    public static function buildTheme($theme, $userTheme = false) {
        $themes = [];
        foreach($theme as $key => $thm) {
            $t = ["id" => $key, "name" => $thm];
            if ($userTheme == $key) {
                $t["selected"] = true;
            }
            $themes[$key] = $t;
        }
        return $themes;
    }


}
