<?php 

namespace Ihidzhov\FaaS;

use SQLite3;

class DB extends SQLite3 {
  
    const SCHEMA_LAMBDA = DATABASE_DIR.'lambda.db';
    const SCHEMA_LOGS = DATABASE_DIR.'logs.db';

    function __construct(string $db) {
        $this->open($db);
    }   
}