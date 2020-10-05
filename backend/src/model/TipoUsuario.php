<?php

namespace Model;

use Core\Model;

class TipoUsuario extends Model {

    function __construct() {

        $this->table = 'TBL_TIPO_USUARIO';

        $this->primary_key = "tipo_id";

        $this->fields['tipo_id'] = [
            'type' => 'integer'
        ];
        $this->fields['tipo_descricao'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required' 
        ];
    }

}