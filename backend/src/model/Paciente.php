<?php

namespace Model;

use Core\Model;

class Paciente extends Model {

    function __construct() {

        $this->table = 'TBL_PACIENTE';

        $this->primary_key = "pac_id";

        $this->fields['pac_id'] = [
            'type' => 'integer'
        ];
        $this->fields['pac_nome'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        $this->fields['pac_uf'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        $this->fields['pac_cidade'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        $this->fields['pac_logradouro'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        $this->fields['pac_bairro'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        $this->fields['pac_numero_casa'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        $this->fields['pac_telefone'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        $this->fields['pac_id_USUARIO'] = [
            'type' => 'integer',
            'validate' => 'Core\Validation::required'
        ];
    }

}