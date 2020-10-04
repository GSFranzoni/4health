<?php

namespace Model;

use Core\Model;

class Atendimento extends Model {

    function __construct() {

        parent::$table = 'TBL_ATENDIMENTO';

        parent::$primary_key = "ate_id";

        parent::$fields['ate_id'] = [
            'type' => 'int'
        ];
        parent::$fields['ate_id_ATENDIMENTO_SOLICITACAO'] = [
            'type' => 'int',
            'validate' => 'Core\Validation::required'
        ];
        parent::$fields['ate_finalizado'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
    }

}