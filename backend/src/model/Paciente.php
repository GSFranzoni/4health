<?php

namespace Model;

use Core\Model;

class Paciente extends Model {

    function __construct() {

        parent::$table = 'TBL_PACIENTE';

        parent::$primary_key = "pac_id";

        parent::$fields['pac_id'] = [
            'type' => 'int'
        ];
        parent::$fields['pac_nome'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        parent::$fields['pac_uf'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        parent::$fields['pac_cidade'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        parent::$fields['pac_logradouro'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        parent::$fields['pac_bairro'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        parent::$fields['pac_numero_casa'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        parent::$fields['pac_telefone'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        parent::$fields['pac_id_USUARIO'] = [
            'type' => 'integer',
            'validate' => 'Core\Validation::required'
        ];
    }

}