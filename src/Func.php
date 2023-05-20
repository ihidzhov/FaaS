<?php 

namespace Ihidzhov\FaaS;

use Ihidzhov\FaaS\Trigger;
use Ihidzhov\FaaS\Runtime;

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

    public function getCodeSnippet(array $fn) :string {
        return file_get_contents(FUNCTIONS_DIR . $fn["hash"] . DIRECTORY_SEPARATOR . "index." .Runtime::FILE_EXT[$fn["runtime"]]);
    }

    public function insert(string $hash, string $functionName, int $triggerType, string $triggerDetails, int $runtime) :int {
        $sql = 'INSERT INTO fn (name, hash, trigger_type, trigger_details,runtime, created_at) 
                    VALUES (:name, :hash, :trigger_type, :trigger_details, :runtime, :created_at )';
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':name', $functionName, SQLITE3_TEXT);
        $stmt->bindValue(':hash', $hash, SQLITE3_TEXT);
        $stmt->bindValue(':trigger_type', $triggerType, SQLITE3_INTEGER);
        $stmt->bindValue(':trigger_details', json_encode($triggerDetails), SQLITE3_TEXT);
        $stmt->bindValue(':runtime', $runtime, SQLITE3_INTEGER);
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

    public function saveToFileSystem($hash, $runtime, $content) {
        if (!is_dir(FUNCTIONS_DIR . $hash)) {
            mkdir(FUNCTIONS_DIR . $hash, 0777, true); // TO DO - change permissions
        }
        file_put_contents(FUNCTIONS_DIR . $hash . DIRECTORY_SEPARATOR . "index." . Runtime::toFileExt($runtime), $content);
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
  
}
