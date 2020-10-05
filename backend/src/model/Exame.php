<?php

namespace Model;

use Core\Database;
use Core\Model;

class Exame extends Model {

    function __construct() {

        $this->table = 'TBL_EXAME';

        $this->primary_key = "exa_id";

        $this->fields['exa_id'] = [
            'type' => 'int'
        ];
        $this->fields['exa_nome'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        $this->fields['exa_resultado'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        $this->fields['exa_laudo'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::datetime'
        ];
        $this->fields['exa_data'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::datetime'
        ];
        $this->fields['exa_id_PACIENTE'] = [
            'type' => 'integer',
            'validate' => 'Core\Validation::required'
        ];
    }

    public function getByPaciente($pac_id) {
        return Database::getQueryBuilder()
            ->table($this->table)
            ->select($this->keys())
            ->where('exa_id_PACIENTE', $pac_id)
            ->get();  
            
    }

}