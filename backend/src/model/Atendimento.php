<?php

namespace Model;

use Core\Model;

class Atendimento extends Model {

    function __construct() {

        $this->table = 'TBL_ATENDIMENTO';

        $this->primary_key = "ate_id";

        $this->fields['ate_id'] = [
            'type' => 'integer'
        ];
        $this->fields['ate_id_ATENDIMENTO_SOLICITACAO'] = [
            'type' => 'integer',
            'validate' => 'Core\Validation::required'
        ];
        $this->fields['ate_finalizado'] = [
            'type' => 'string'
        ];
    }

}