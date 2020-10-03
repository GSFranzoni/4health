<?php
namespace Core;

use Errors\ValidationException as ValidationException;
use Errors\InvalidPropertyException as InvalidPropertyException;
use Model\Medico as Medico;

class Controller {

    private $model;

    public function __construct($model) {
        $this->model = new $model;
    }

    public function get($id) {
        $result = $this->model->get($id);
        if(!$result) {
            throw new \Exception("A chave informada não corresponde à nenhum registro!");
        }
        return json_encode([
            'message' => 'Registro recuperado com sucesso!',
            'body' => $result
        ]);
    }

    public function getAll() {
        return json_encode([
            'message' => 'Dados salvos com sucesso',
            'body' => [ $this->model->getAll() ]
        ]);
    }

    public function insert($data) {
        $id = $this->model->save($data);
        return json_encode([
            'message' => 'Dados salvos com sucesso',
            'body' => [ 'id' => $id ]
        ]);
    }

    public function delete($id) {

    }

    public function update($id) {
        
    }

}