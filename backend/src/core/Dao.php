<?php
namespace Core;

use Core\Database as Database;
use Exception;
use PDO;

class Dao {

    private $model;

    private $SQL_INSERT = "";
    private $SQL_UPDATE = "";
    private $SQL_SELECT = "";
    private $SQL_DELETE = "";
    private $SQL_SELECT_BY_ID = "";

    public function __construct($model) {

        $this->model = new $model;

        $binds = ":". implode(", :", $this->model->keys());
        
        $fields = implode(", ", $this->model->keys());
        $fields_not_hidden = implode(", ", $this->model->keys_not_hidden());

        $binds_update = implode(", ", array_map(function ($key) {
            return "$key = :$key";
        }, $this->model->keys()));

        $this->SQL_INSERT = "DELETE FROM ". $this->model->table. " WHERE ". $this->model->primary_key. "=:". $this->model->primary_key;
        $this->SQL_INSERT = "INSERT INTO ". $this->model->table. " (${fields}) VALUES (${binds})";
        $this->SQL_UPDATE = "UPDATE ". $this->model->table. " SET ${binds_update} WHERE ". $this->model->primary_key. "=:". $this->model->primary_key;
        $this->SQL_SELECT = "SELECT ${fields_not_hidden} FROM ". $this->model->table;
        $this->SQL_SELECT_BY_PRIMARY = "SELECT ${fields_not_hidden} FROM ". $this->model->table. " WHERE ". $this->model->primary_key. "=:". $this->model->primary_key;
    }

    public function get(int $id) {
        $stmt = Database::getInstance()->prepare($this->SQL_SELECT_BY_PRIMARY);
        $stmt->bindParam(':'. $this->model->primary_key, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll() {
        $stmt = Database::getInstance()->prepare($this->SQL_SELECT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($object) {
        $stmt = Database::getInstance()->prepare($this->SQL_INSERT);
        foreach ($this->model->fields as $field => $db_field) {
            $stmt->bindParam(":${field}", $object[$field]);
        }
        $stmt->execute();
        return Database::getInstance()->lastInsertId();
    }

    public function update($id, $data) {
        
    }

    public function delete($id) {
        if(!$this->get($id)) {
            throw new Exception("O registro com id $id não existe!");
        }
        $stmt = Database::getInstance()->prepare($this->SQL_INSERT);
        $stmt->bindParam(":". $this->model->primary_key, $id);
        $stmt->execute();
    }
    
}