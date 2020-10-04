<?php

namespace Model;

use Core\Model;
use Core\Validation;

class Medico extends Model {

    function __construct() {

        parent::$table = 'TBL_MEDICO';

        parent::$primary_key = "med_id";

        parent::$fields['med_id'] = [
            'type' => 'int'
        ];
        parent::$fields['med_nome'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required' 
        ];
        parent::$fields['med_crm'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required' 
        ];
        parent::$fields['med_especialidade'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required' 
        ];
        parent::$fields['med_id_USUARIO'] = [
            'type' => 'integer',
            'validate' => 'Core\Validation::required' 
        ];
    }

}