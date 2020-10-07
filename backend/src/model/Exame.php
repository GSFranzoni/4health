<?php

namespace Model;

use Core\Database;
use Core\Model;

class Exame extends Model {

    function __construct() {

        $this->table = 'EXAME';

        $this->primary_key = "id";

        $this->fields['id'] = [
            'type' => 'integer'
        ];
        $this->fields['nome'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        $this->fields['resultado'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        $this->fields['laudo'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        $this->fields['data'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::datetime'
        ];
        $this->fields['paciente'] = [
            'type' => 'integer',
            'validate' => 'Core\Validation::required'
        ];
        $this->fields['medico'] = [
            'type' => 'integer',
            'validate' => 'Core\Validation::required'
        ];
    }

    public function getByPaciente($pac_id) {
        return Database::getQueryBuilder()
            ->table($this->table)
            ->select($this->keys())
            ->where('paciente', $pac_id)
            ->get();  
    }

    public function getByMedico($med_id) {
        return Database::getQueryBuilder()
            ->table($this->table)
            ->select($this->keys())
            ->where('medico', $med_id)
            ->get();  
    }

}