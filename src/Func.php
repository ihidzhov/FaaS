<?php 

namespace Ihidzhov\FaaS;

use Ihidzhov\FaaS\Trigger;

class Func {

    public function __construct(protected $db = null) { }
 
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

    public function getByName(string $str = null) {
        if (!$str) {
            return false;
        }
        $stmt = $this->db->prepare('SELECT * FROM fn WHERE name = :str');
        $stmt->bindValue(':str', $str, SQLITE3_TEXT);
        $result = $stmt->execute();
        return $result->fetchArray(\SQLITE3_ASSOC);
    }

    public function getCodeSnippet(array $fn) :string {
        return file_get_contents(FUNCTIONS_DIR . $fn["hash"] . DIRECTORY_SEPARATOR . "index.php");
    }

    public function insert(string $hash, string $functionName, int $triggerType, string $triggerDetails) :int {
        $sql = 'INSERT INTO fn (name, hash, trigger_type, trigger_details, created_at) 
                    VALUES (:name, :hash, :trigger_type, :trigger_details, :created_at )';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':name', $functionName, SQLITE3_TEXT);
        $stmt->bindValue(':hash', $hash, SQLITE3_TEXT);
        $stmt->bindValue(':trigger_type', $triggerType, SQLITE3_INTEGER);
        $stmt->bindValue(':trigger_details', $triggerDetails, SQLITE3_TEXT);
        $stmt->bindValue(':created_at', date("Y-m-d H:i:s"), SQLITE3_TEXT);

        $result = $stmt->execute();
        return $this->db->lastInsertRowID();
    }

    public function update(int $id, int $triggerType, string $triggerDetails = "") {
        $sql = 'UPDATE fn SET trigger_type = :trigger_type, trigger_details = :trigger_details WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', (int)$id, SQLITE3_INTEGER);
        $stmt->bindValue(':trigger_type', $triggerType, SQLITE3_INTEGER);
        $stmt->bindValue(':trigger_details', $triggerDetails, SQLITE3_TEXT);
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

    public function saveToFileSystem($hash, $content) {
        if (!is_dir(FUNCTIONS_DIR . $hash)) {
            mkdir(FUNCTIONS_DIR . $hash, 0777, true); // TO DO - change permissions
        }
        file_put_contents(FUNCTIONS_DIR . $hash . DIRECTORY_SEPARATOR . "index.php", $content);
    }

    public function removeFiles($folder) {
        if (is_dir(FUNCTIONS_DIR . $folder)) {
            array_map('unlink', glob(FUNCTIONS_DIR."$folder/*.*"));
            rmdir(FUNCTIONS_DIR . $folder);
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

    public function getCount() :int {
        $stmt = $this->db->prepare('SELECT COUNT(id) AS cnt FROM fn'); 
        $result = $stmt->execute();
        return $result->fetchArray(\SQLITE3_ASSOC)["cnt"];
    }

    public function getMany($offset = 0, $limit = 10, $search = false, $order = "DESC") :array {
        $where = "";
        if ($search) {
            $where = " WHERE name LIKE '%" . $search ."%' ";
        }
        $result = $this->db->query("SELECT * FROM fn {$where} ORDER BY id {$order} LIMIT {$limit} ");
        $data = [];
        while($row = $result->fetchArray(\SQLITE3_ASSOC)) {
            $row["trigger_name"] = Trigger::AS_ARRAY[$row["trigger_type"]];  
            $row["link"] = '<a href="index.php?action=func&id='.$row["id"].'">'.$row["name"].'</a>'; 
            $data[] = $row;
        }
        $countResult = $this->db->query("SELECT COUNT(id) AS cnt FROM fn {$where}");
        $count = $countResult->fetchArray(\SQLITE3_ASSOC)["cnt"];

        return ["rows"=>$data, "total"=>$count, "totalNotFiltered" => $count];
    }
    
    public function getList($limit = 5, $order = "DESC") :array {
        $result = $this->db->query("SELECT * FROM fn ORDER BY id {$order} LIMIT {$limit} ");
        $data = [];
        while($row = $result->fetchArray(\SQLITE3_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }

    public function getScheduled($limit = false) :array {
        $queryLimit = "";
        if ($limit) {
            $queryLimit = " LIMIT {$limit} ";
        }
        $trigger = Trigger::TRIGGER_SCHEDULE;
        $result = $this->db->query("SELECT * FROM fn WHERE trigger_type = {$trigger} ORDER BY id ASC {$queryLimit} ");
        $data = [];
        while($row = $result->fetchArray(\SQLITE3_ASSOC)) {
            $data[] = $row;
        }
        return $data;
    }
  
}
