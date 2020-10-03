<?php

namespace Model;

use Core\Model;

class Usuario extends Model {

    function __construct() {

        $this->table = 'TBL_USUARIO';

        $this->primary_key = "usr_id";

        $this->fields['usr_id'] = [
            'type' => 'int',
            'validate' => 'Core\Validation::required'
        ];
        $this->fields['usr_cpf'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::cpf' 
        ];
        $this->fields['usr_senha'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required',
            'hidden' => true 
        ];
        $this->fields['usr_ativo'] = [
            'type' => 'boolean',
            'validate' => 'Core\Validation::required' 
        ];
        $this->fields['usr_id_TIPO_USUARIO'] = [
            'type' => 'int',
            'validate' => 'Core\Validation::required' 
        ];
    }

}