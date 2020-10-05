<?php

namespace Model;

use Core\Model;

class Paciente extends Model {

    function __construct() {

        $this->table = 'PACIENTE';

        $this->primary_key = "id";

        $this->fields['id'] = [
            'type' => 'integer'
        ];
        $this->fields['nome'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        $this->fields['uf'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        $this->fields['cidade'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        $this->fields['logradouro'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        $this->fields['bairro'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        $this->fields['numero_casa'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        $this->fields['telefone'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        $this->fields['usuario'] = [
            'type' => 'integer',
            'validate' => 'Core\Validation::required'
        ];
    }

}