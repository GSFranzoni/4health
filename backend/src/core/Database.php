<?php 

namespace Core;

use PDO;
use PDOException;

class Database {

    public static $connection = null;

    public static function getInstance() {
        if(!isset(static::$connection)) {
            try {
                static::$connection = new PDO(
                    "mysql:host=".getenv("host"). 
                    ";port=".getenv("port").
                    ";dbname=".getenv("database"),
                    "docker",
                    "docker"
                );
                static::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(PDOException $e) {
                print $e->getMessage();
            }
        }
        return static::$connection;
    }

}

?>