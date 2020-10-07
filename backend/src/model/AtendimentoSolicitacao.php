<?php

namespace Model;

use Core\Database;
use Core\Model;

class AtendimentoSolicitacao extends Model {

    function __construct() {

        $this->table = 'ATENDIMENTO_SOLICITACAO';

        $this->primary_key = "id";

        $this->fields['id'] = [
            'type' => 'integer'
        ];
        $this->fields['paciente'] = [
            'type' => 'integer',
            'validate' => 'Core\Validation::required'
        ];
        $this->fields['medico'] = [
            'type' => 'integer',
            'validate' => 'Core\Validation::required'
        ];
        $this->fields['aceito'] = [
            'type' => 'boolean',
            'nullable' => true
        ];
        $this->fields['data'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::datetime'
        ];
    }

    function getByMedico(int $med_primary) {
        $this->validate([
            'medico' => $med_primary
        ]);
        return Database::getQueryBuilder()
            ->table($this->table)
            ->select()
            ->where('medico', '=', $med_primary)
            ->whereNull('aceito')
            ->get();
    }

    function getByPaciente(int $pac_primary) {
        $this->validate([
            'paciente' => $pac_primary
        ]);
        return Database::getQueryBuilder()
            ->table($this->table)
            ->select()
            ->where('paciente', '=', $pac_primary)
            ->whereNull('aceito')
            ->get();
    }

}