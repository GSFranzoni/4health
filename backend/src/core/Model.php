<?php
namespace Core;

use Errors\ValidationException as ValidationException;
use Core\Validation;
use Core\Dao as Dao;

abstract class Model {

    static $fields = [];
    static $table = "", $primary_key = "id";

    public function save($data) {
        $values = $this->valid_fields($data);
        $this->validate_all($values);
        Database::getQueryBuilder()
            ->table(self::$table)
            ->insert($values)
            ->execute();
        return Database::last();
    }

    public function get(int $primary) {
        return Database::getQueryBuilder()
            ->table(self::$table)
            ->select()
            ->where(self::$primary_key, '=', $primary)
            ->get();
    }

    public function getAll() {
        return Database::getQueryBuilder()
            ->table(self::$table)
            ->select()
            ->get();
    }

    public function update($primary, $data) {
        $values = $this->valid_fields($data);
        $this->validate($values);
        return Database::getQueryBuilder()
            ->table(self::$table)
            ->update($values)
            ->where(self::$primary_key, '=', $primary)
            ->execute();
    }

    public function delete($primary) {
        return Database::getQueryBuilder()
            ->table(self::$table)
            ->delete()
            ->where(self::$primary_key, '=', $primary)
            ->execute();
    }

    protected function validate($data) {
        foreach ($data as $key => $value) {
            $field = self::$fields[$key];
            $this->check_field_validate($key, $value);
            $this->check_type_validate($key, $value, $field['type']);
        }
    }

    protected function validate_all($data) {
        foreach (self::$fields as $key => $value) {
            $this->check_field_validate($key, $data[$key]);
            $this->check_type_validate($key, $data[$key], $value['type']);
        }
    }

    protected function check_field_validate($key, $value) {
        $validate_function = self::$fields[$key]['validate'];
        if($validate_function and !call_user_func($validate_function, $value)) {
            throw new ValidationException("Erro de validação: o campo $key tem um valor inválido!");
        }
    }

    protected function check_type_validate($key, $value, $type) {
        if(!call_user_func_array('Core\Validation::type', [ $value, $type ])) {
            throw new ValidationException("Erro de validação: o campo $key tem um tipo inválido!");
        }
    }

    public function keys_not_hidden() {
        $not_hidden = array_filter(self::$fields, function ($field) {
            return !array_key_exists('hidden', self::$fields[$field]);
        }, ARRAY_FILTER_USE_KEY);
        return array_keys($not_hidden);
    }

    public function keys() {
        return array_keys(self::$fields);
    }

    private function valid_fields($data) {
        return array_filter($data, function ($key) {
            return in_array($key, $this->keys());
        }, ARRAY_FILTER_USE_KEY);
    }

}

// abstract class Model implements \JsonSerializable {

//     public $id, $validations = [], $table;

//     public function __construct($array = [], $table) {
//         $this->id = 0;
//         $this->fill($array);
//         $this->table = $table;
//     }

//     private function fill(array $array) {
//         foreach ($array as $key => $value) {
//             $this->$key = $value;
//         }
//         return $this;
//     }

//     private function validate($field, $value) {
//         if(!$this->validations[$field]) {
//             return true;
//         }
//         return call_user_func($this->validations[$field], $value);
//     }

//     public function jsonSerialize(): array {
//         $array = [];
//         foreach ($this->fields() as $field => $_) {
//             $array[$field] = $this->$field;
//         }
//         return $array;
//     }

//     public function json(): string {
//         return json_encode($this);
//     }

//     public abstract static function fields(): array;
// }