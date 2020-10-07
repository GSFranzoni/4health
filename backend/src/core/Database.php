<?php 

namespace Core;

use PDO;
use PDOException;

class Database {

    private static $connection = null;

    public static function getInstance(): PDO {
        if(!isset(static::$connection)) {
            try {
                static::$connection = new PDO(
                    "mysql:host=".getenv("host"). 
                    ";port=".getenv("port").
                    ";dbname=".getenv("database"),
                    getenv("user"),
                    getenv("password")
                );
                static::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                static::$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            }
            catch(PDOException $e) {
                print $e->getMessage();
            }
        }
        return static::$connection;
    }

    public static function getQueryBuilder(): \ClanCats\Hydrahon\Builder {
        return new \ClanCats\Hydrahon\Builder('mysql', function($query, $queryString, $queryParameters) {
            $statement = Database::getInstance()->prepare($queryString);
            $statement->execute($queryParameters);
            if ($query instanceof \ClanCats\Hydrahon\Query\Sql\FetchableInterface)
            {
                return $statement->fetchAll(\PDO::FETCH_ASSOC);
            }
        });
    }

    public static function query($queryString) {
        $statement = Database::getInstance()->prepare($queryString);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function last(): int {
        return static::getInstance()->lastInsertId();
    }
}

?>