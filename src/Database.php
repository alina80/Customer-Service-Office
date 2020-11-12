<?php

require __DIR__ . '/../config/config.php';

class Database

{
    private static $instance;

    private $connection;

    private function __construct()
    {
        $host = HOST;
        $user = USER;
        $password = PASSWORD;
        $db = DB;
        $pass = true;
        $conn = null;

        try {
            $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);
        } catch (Exception $e) {
            $pass = false;
            echo $e->getMessage();
        }

        if ($pass) {
            $this->connection = $conn;
        }

    }

    public function getConnection()
    {
        return $this->connection;
    }

    public static function getInstance()
    {
        if(!self::$instance)
        {
            self::$instance = new self();
        }

        return self::$instance;
    }
}