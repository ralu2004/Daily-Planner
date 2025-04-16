<?php

namespace RalucaAdam\MyDailyPlanner\models;

use RalucaAdam\MyDailyPlanner\helpers\Database;

class Model
{
    protected $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    public function query($sql, $params = [])
    {
        return Database::query($sql, $params);
    }

    public static function fetchAll($sql, $params = [])
    {
        return Database::fetchAll($sql, $params);
    }

    public function fetchOne($sql, $params = [])
    {
        return Database::fetch($sql, $params);
    }
}
?>