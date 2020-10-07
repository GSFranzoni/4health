<?php
namespace Core;

use Errors\ValidationException as ValidationException;
use Core\Validation;
use Core\Dao as Dao;

abstract class Model {

    protected $fields = [], $table = "", $primary_key = "";

    public function save($data) {
        $data[$this->primary_key] = 0;
        $values = $this->validFields($data);
        $this->validateAll($values);
        Database::getQueryBuilder()
            ->table($this->table)
            ->insert($values)
            ->execute();
        return Database::last();
    }

    public function get(int $primary) {
        return Database::getQueryBuilder()
            ->table($this->table)
            ->select($this->keysNotHidden())
            ->where($this->primary_key, '=', $primary)
            ->get()[0];
    }

    public function getAll() {
        return Database::getQueryBuilder()
            ->table($this->table)
            ->select($this->keysNotHidden())
            ->get();
    }

    public function update($primary, $data) {
        $values = $this->validFields($data);
        $this->validate($values);
        return Database::getQueryBuilder()
            ->table($this->table)
            ->update($values)
            ->where($this->primary_key, '=', $primary)
            ->execute();
    }

    public function delete($primary) {
        return Database::getQueryBuilder()
            ->table($this->table)
            ->delete()
            ->where($this->primary_key, '=', $primary)
            ->execute();
    }

    protected function validate($data) {
        foreach ($data as $key => $value) {
            $field = $this->fields[$key];
            $this->checkFieldValidate($key, $value);
            $this->checkTypeValidate($key, $value, $field['type']);
        }
    }

    protected function validateAll($data) {
        foreach ($this->fields as $key => $value) {
            $this->checkFieldValidate($key, $data[$key]);
            $this->checkTypeValidate($key, $data[$key], $value['type']);
        }
    }

    protected function checkFieldValidate($key, $value) {
        $validate_function = $this->fields[$key]['validate'];
        if($validate_function and !call_user_func($validate_function, $value)) {
            throw new ValidationException("Erro de validação: o campo $key tem um valor inválido!");
        }
    }

    protected function checkTypeValidate($key, $value, $type) {
        if(empty($value) and !empty($this->fields[$key]['nullable'])) {
            return;
        }
        if(!call_user_func_array('Core\Validation::type', [ $value, $type ])) {
            throw new ValidationException("Erro de validação: o campo $key tem um tipo inválido!");
        }
    }

    public function keysNotHidden() {
        $not_hidden = array_filter($this->fields, function ($field) {
            return !array_key_exists('hidden', $this->fields[$field]);
        }, ARRAY_FILTER_USE_KEY);
        return array_keys($not_hidden);
    }

    public function keys() {
        return array_keys($this->fields);
    }

    protected function validFields($data) {
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