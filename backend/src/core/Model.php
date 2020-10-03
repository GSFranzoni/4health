<?php
namespace Core;

use Errors\ValidationException as ValidationException;
use Core\Validation;
use Core\Dao as Dao;

abstract class Model {

    public $fields = [], $table, $primary_key = "id";

    public function save($data) {
        $values = $this->valid_fields($data);
        $this->validate($values);
        return (int)(new Dao(get_called_class()))->insert($values);
    }

    public function get(int $id) {
        return (new Dao(get_called_class()))->get($id);
    }

    public function getAll() {
        return (new Dao(get_called_class()))->getAll();
    }

    private function validate($values) {
        foreach ($this->fields as $field => $field_value) {
            $this->check_field_validate($field_value['validate'], $field, $values[$field]);
            $this->check_type_validate($field_value['validate'], $field, $values[$field], $field_value['type']);
        }
    }

    private function check_field_validate($validate_function, $field, $value) {
        if($validate_function and !call_user_func($validate_function, $value)) {
            throw new ValidationException("Erro de validação: o campo $field tem um valor inválido!");
        }
    }

    private function check_type_validate($validate_function, $field, $value, $type) {
        if($validate_function and !call_user_func_array('Core\Validation::type', [ $value, $type ])) {
            throw new ValidationException("Erro de validação: o campo $field tem um tipo inválido!");
        }
    }

    public function keys_not_hidden() {
        $not_hidden = array_filter($this->fields, function ($field) {
            return !array_key_exists('hidden', $this->fields[$field]);
        }, ARRAY_FILTER_USE_KEY);
        return array_keys($not_hidden);
    }

    public function keys() {
        return array_keys($this->fields);
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