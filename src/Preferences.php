<?php 

namespace Ihidzhov\FaaS;

class Preferences {

    const SITE_THEME_KEY = "site_theme";
    const SITE_THEME_DEFAULT = 4;

    const EDITOR_THEME_KEY = "editor_theme";
    const EDITOR_THEME_DEFAULT = "terminal";

    const THEME_ARRAY = [
        self::SITE_THEME_KEY => self::SITE_THEME_DEFAULT,
        self::EDITOR_THEME_KEY => self::EDITOR_THEME_DEFAULT,
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

    const EDITOR_THEMES = [
        1 => "xcode",
        2 => "cobalt",
        3 => "eclipse",
        4 => "solarized_dark", 
        5 => "clouds",
        6 => "dawn",
        7 => "terminal",
        8 => "dracula",
        9 => "github",
        10 => "monokai",
    ];
    
    public function __construct(protected $db = null) { }

    public function getOne(string $name = null) {
        if (!$name || !isset(self::THEME_ARRAY[$name])) {
            throw new Exception("The name must be provided or valid");
        }
        $stmt = $this->db->prepare('SELECT * FROM preferences WHERE name = :name');
        $stmt->bindValue(':name', $name, SQLITE3_TEXT);
        $result = $stmt->execute();
        $data = $result->fetchArray(\SQLITE3_ASSOC);
        if (isset($data["name"])) {
            return $data["value"];
        }
        return self::THEME_ARRAY[$name];
    }

    public function update($name = null, $value = null) {
        if (!$name) {
            throw new Exception("The name must be provided");
        }
        try {
            $sql = 'INSERT OR REPLACE INTO preferences(name, value)  VALUES(:name, :value)';
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':name', (string)trim($name), SQLITE3_TEXT); 
            $stmt->bindValue(':value', (string)$value, SQLITE3_TEXT);
            return $stmt->execute();
        } catch (Throlable $t) {

        }
    }

}