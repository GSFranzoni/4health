<?php

namespace Model;

use Core\Model;

class TipoUsuario extends Model {

    function __construct() {

        parent::$table = 'TBL_TIPO_USUARIO';

        parent::$primary_key = "tipo_id";

        parent::$fields['tipo_id'] = [
            'type' => 'int'
        ];
        parent::$fields['tipo_descricao'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required' 
        ];
    }

}