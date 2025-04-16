<?php
namespace RalucaAdam\MyDailyPlanner\helpers;

use PDO;
use PDOException;

class Database
{
    private static $connection;

    // Connect method is called once to establish the connection
    public static function connect()
    {
        if (!self::$connection) {
            try {
                self::$connection = new PDO('pgsql:host=localhost;dbname=daily_planner', 'postgres', 'ralucutza0204');
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Database connection failed: ' . $e->getMessage());
            }
        }
        return self::$connection;
    }

    // Get the existing connection
    public static function getConnection()
    {
        return self::$connection ?: self::connect(); // Connect if not already connected
    }

    // General query execution method
    public static function query($sql, $params = [])
    {
        try {
            // Use the existing connection
            $conn = self::getConnection();

            // Prepare and execute the SQL statement
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);

            return $stmt;
        } catch (PDOException $e) {
            // Log and re-throw exception if there is an issue
            error_log('Database query error: ' . $e->getMessage());
            throw $e;
        }
    }

    public static function fetch($sql, $params = [])
    {
        $stmt = self::query($sql, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function fetchAll($sql, $params = [])
    {
        $stmt = self::query($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function lastInsertId($table, $idColumn)
    {
        $sql = "SELECT currval(pg_get_serial_sequence('$table', '$idColumn')) AS id";
        return self::fetch($sql)['id'];
    }
}
?>