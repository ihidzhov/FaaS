<?php 

class DB extends SQLite3
{
    function __construct()
    {
        $this->open('databases/lambda.db');
    }
}

$db = new DB();
$sql = 'CREATE TABLE fn (
    id INTEGER PRIMARY KEY AUTOINCREMENT, 
    name VARCHAR(255) UNIQUE , 
    trigger_type INTEGER NOT NULL,
    trigger_details TEXT NULL,
    hash VARCHAR(255) NOT NULL,  
    created_at TEXT NOT NULL
)';
$db->exec($sql);
 
 