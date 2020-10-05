<?php

namespace Model;

use Core\Model;

class TipoUsuario extends Model {

    function __construct() {

        $this->table = 'TIPO_USUARIO';

        $this->primary_key = "id";

        $this->fields['id'] = [
            'type' => 'integer'
        ];
        $this->fields['descricao'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required' 
        ];
    }

}