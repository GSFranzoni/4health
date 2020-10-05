<?php

namespace Model;

use Core\Model;
use Core\Validation;

class Medico extends Model {

    function __construct() {

        $this->table = 'TBL_MEDICO';

        $this->primary_key = "med_id";

        $this->fields['med_id'] = [
            'type' => 'integer'
        ];
        $this->fields['med_nome'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required' 
        ];
        $this->fields['med_crm'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required' 
        ];
        $this->fields['med_especialidade'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required' 
        ];
        $this->fields['med_id_USUARIO'] = [
            'type' => 'integer',
            'validate' => 'Core\Validation::required' 
        ];
    }

}