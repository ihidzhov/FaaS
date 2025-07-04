<?php 

namespace Ihidzhov\FaaS;

use json_decode;
use json_last_error;

class Config {

    const FUNCTIONS_KEY = "labmda";

    public function __construct(protected $db = null) { }

    public function get(?string $name = null) {
        if (!$name) {
            return false;
        }
        $stmt = $this->db->prepare('SELECT * FROM config WHERE name = :name');
        $stmt->bindValue(':name', $name, SQLITE3_TEXT);
        $result = $stmt->execute();
        return $result->fetchArray(\SQLITE3_ASSOC);
    }

    public function update($name = null, $value = null) {
        if (!$name) {
            throw new Exception("The name must be provided");
        }
        try {
            $sql = 'INSERT OR REPLACE INTO config(name, val, edited_at) 
                        VALUES(:name, :val, :edited_at)';
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':name', (string)trim($name), SQLITE3_TEXT); 
            $stmt->bindValue(':val', (string)$value, SQLITE3_TEXT); 
            $stmt->bindValue(':edited_at', date("Y-m-d H:i:s"), SQLITE3_TEXT); 
            return $stmt->execute();
        } catch (Throlable $t) {

        }
    }

    public static function JSONToArray($json = false) :array {
        if (!$json) {
            return [];
        }
        $array = json_decode($json, true);
        if (json_last_error() === JSON_ERROR_NONE) {
            return $array;    
        }
        return [];
    }

}