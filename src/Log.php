<?php 

namespace Ihidzhov\FaaS;

use Throwable;

class Log {
    
    const LEVEL_INFO = 1;
    const LEVEL_ERROR = 2;

    const LEVEL_NAME= [
        self::LEVEL_INFO => "Info",
        self::LEVEL_ERROR => "Error",
    ];
 
    public static function toLambda($dbLogs, int $level, string $name, string $message = "") {
        try {
            $sql = 'INSERT INTO lambda (level, name, message, created_at) 
                        VALUES (:level, :name, :message, :created_at )';
            $stmt = $dbLogs->prepare($sql);
            $stmt->bindValue(':level', $level, SQLITE3_INTEGER);
            $stmt->bindValue(':name', $name, SQLITE3_TEXT);
            $stmt->bindValue(':message', $message, SQLITE3_TEXT);
            $stmt->bindValue(':created_at', date("Y-m-d H:i:s"), SQLITE3_TEXT);
            $stmt->execute();
        } catch(Throwable $t) {}
     }

    public static function toWeb() {

    }

    public static function getMany($dbLogs, int $offset = 0, int $limit = 10, ?string $search = null, string $order = "DESC") {
        try {
            $where = "";
            if ($search) {
                $where = " WHERE name LIKE '%" . $search ."%' ";
            }
            $stmt = $dbLogs->prepare("SELECT * FROM `lambda` {$where} ORDER BY id {$order} LIMIT :offset, :limit");
            $stmt->bindValue(':offset', (int) $offset, SQLITE3_INTEGER);
            $stmt->bindValue(':limit', (int) $limit, SQLITE3_INTEGER);
            $result = $stmt->execute();
            $data = [];
            while($row = $result->fetchArray(\SQLITE3_ASSOC)) {
                $row["level_name"] = self::LEVEL_NAME[$row["level"]];
                $data[] = $row;
            }
            $countResult = $dbLogs->query("SELECT COUNT(id) AS cnt FROM `lambda` {$where}");
            $count = $countResult->fetchArray(\SQLITE3_ASSOC)["cnt"];
    
            return ["rows"=>$data, "total"=>$count, "totalNotFiltered" => $count];
        } catch(Throwable $t) {  }
    }

}