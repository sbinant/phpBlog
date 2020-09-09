<?php
namespace App;
use \PDO;

class Connection {

    public static function getPDO(): PDO
    {
        // your own information below
        return $pdo = new PDO('mysql:dbname=your_dbname;host=your_host', 'your_user_name', 'your_user_password', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}