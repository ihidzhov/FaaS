<?php 

namespace Ihidzhov\FaaS;

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

    public static function getMany($dbLogs, $start = 0, $results = 100, $order = "DESC") {
        try {
            $stmt = $dbLogs->prepare('SELECT * FROM `lambda` ORDER BY id desc LIMIT :start, :results ');
            $stmt->bindValue(':ord', $order, SQLITE3_TEXT);
            $stmt->bindValue(':start', (int) $start, SQLITE3_INTEGER);
            $stmt->bindValue(':results', (int) $results, SQLITE3_INTEGER);
            $result = $stmt->execute();
            $data = [];
            while($row = $result->fetchArray(\SQLITE3_ASSOC)) {
                $row["level_name"] = self::LEVEL_NAME[$row["level"]];
                $data[] = $row;
            }
            return $data;
        } catch(Throwable $t) {}
    }

}