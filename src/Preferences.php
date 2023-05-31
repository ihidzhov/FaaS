<?php 

namespace Ihidzhov\FaaS;

class Preferences {

    const SITE_THEME_KEY = "site_theme";
    const SITE_THEME_DEFAULT = 4;

    public function __construct(protected $db = null) { }

    public function getOne(string $name = null) {
        if (!$name) {
            return false;
        }
        $stmt = $this->db->prepare('SELECT * FROM preferences WHERE name = :name');
        $stmt->bindValue(':name', $name, SQLITE3_TEXT);
        $result = $stmt->execute();
        $data = $result->fetchArray(\SQLITE3_ASSOC);
        if (isset($data["name"])) {
            return $data["value"];
        }
        return self::SITE_THEME_DEFAULT;
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