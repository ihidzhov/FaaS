<?php 

class DBLambda extends SQLite3
{
    function __construct()
    {
        $this->open('database/lambda.db');
    }
}

class DBLogs extends SQLite3
{
    function __construct()
    {
        $this->open('database/logs.db');
    }
}

$dbLambda = new DBLambda();
$dbLogs = new DBLogs();

$sql = 'CREATE TABLE IF NOT EXISTS fn (
    id INTEGER PRIMARY KEY AUTOINCREMENT, 
    name VARCHAR(255) UNIQUE , 
    trigger_type INTEGER NOT NULL,
    trigger_details TEXT NULL,
    hash VARCHAR(255) NOT NULL,  
    created_at TEXT NOT NULL
)';
$dbLambda->exec($sql);

$sql = 'DROP TABLE lambda';
$dbLogs->exec($sql);

$sql = 'CREATE TABLE IF NOT EXISTS lambda (
    id INTEGER PRIMARY KEY AUTOINCREMENT, 
    level INTEGER NOT NULL,
    name VARCHAR(255), 
    message TEXT NULL,
    created_at TEXT NOT NULL
)';
$dbLogs->exec($sql);
