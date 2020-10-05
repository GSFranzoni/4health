<?php

namespace Model;

use Core\Model;

class Atendimento extends Model {

    function __construct() {

        $this->table = 'ATENDIMENTO';

        $this->primary_key = "id";

        $this->fields['id'] = [
            'type' => 'integer'
        ];
        $this->fields['atendimento_solicitacao'] = [
            'type' => 'integer',
            'validate' => 'Core\Validation::required'
        ];
        $this->fields['finalizado'] = [
            'type' => 'string'
        ];
    }

}