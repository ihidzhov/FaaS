<?php 

namespace Ihidzhov\FaaS;

use Ihidzhov\FaaS\Trigger;

class Func {

    public function __construct(protected $db = null) {
        
    }
 
    public function getAll() {
        $result = $this->db->query('SELECT * FROM fn');
        $data = [];
        while($row = $result->fetchArray(\SQLITE3_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

    public function get(int|null $id = null) {
        if (!$id) {
            return false;
        }
        $stmt = $this->db->prepare('SELECT * FROM fn WHERE id = :id');
        $stmt->bindValue(':id', $id, SQLITE3_INTEGER);
        $result = $stmt->execute();
        return $result->fetchArray(\SQLITE3_ASSOC);
    }

    public function getCodeSnippet(array $fn) :string {
        return file_get_contents(FUNCTIONS_DIR . $fn["hash"].".php");
    }

    public function insert($hash, $functionName, $triggerType, $triggerDetails = []) {
        $sql = 'INSERT INTO fn (name, hash, trigger_type, trigger_details, created_at) 
                    VALUES (:name, :hash, :trigger_type, :trigger_details, :created_at )';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':name', $functionName, SQLITE3_TEXT);
        $stmt->bindValue(':hash', $hash, SQLITE3_TEXT);
        $stmt->bindValue(':trigger_type', $triggerType, SQLITE3_INTEGER);
        $stmt->bindValue(':trigger_details', json_encode($triggerDetails), SQLITE3_TEXT);
        $stmt->bindValue(':created_at', date("Y-m-d H:i:s"), SQLITE3_TEXT);

        $result = $stmt->execute();
        return $this->db->lastInsertRowID();
    }

    public function update($id, $triggerType, $triggerDetails = []) {
        $sql = 'UPDATE fn SET trigger_type = :trigger_type, trigger_details = :trigger_details WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', (int)$id, SQLITE3_INTEGER);
        $stmt->bindValue(':trigger_type', $triggerType, SQLITE3_INTEGER);
        $stmt->bindValue(':trigger_details', json_encode($triggerDetails), SQLITE3_TEXT);
        return $stmt->execute();
    }

    public function delete($id) {
        if (!$id) {
            return false;
        }
        $sql = 'DELETE FROM fn WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', (int)$id, SQLITE3_INTEGER);
        return $stmt->execute();
    }

    public function generateHash($functionName) {
        return md5($functionName . time());
    }

    public function generateFileName($hash, $ext = "php") {
        return $hash . "." . $ext;
    }

    public function saveToFile($name, $content) {
        file_put_contents(FUNCTIONS_DIR.$name, $content);
    }

    public function removeFiles($filename) {
        if (file_exists(FUNCTIONS_DIR.$filename)) {
            unlink(FUNCTIONS_DIR.$filename);
        }
    }

    public function getHTTPHost() {
        $http = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
        return $http."://".$_SERVER["HTTP_HOST"] . "/";
    }

    public function prepareForListing($fns) {
        foreach($fns as $key => $fn) {
            $fns[$key]["trigger"] = Trigger::AS_ARRAY[$fn["trigger_type"]];  
        }

        return $fns;
    }
  
}
