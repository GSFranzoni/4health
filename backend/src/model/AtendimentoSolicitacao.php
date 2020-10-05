<?php

namespace Model;

use Core\Database;
use Core\Model;

class AtendimentoSolicitacao extends Model {

    function __construct() {

        $this->table = 'TBL_ATENDIMENTO_SOLICITACAO';

        $this->primary_key = "ats_id";

        $this->fields['ats_id'] = [
            'type' => 'integer'
        ];
        $this->fields['ats_id_PACIENTE'] = [
            'type' => 'integer',
            'validate' => 'Core\Validation::required'
        ];
        $this->fields['ats_id_MEDICO'] = [
            'type' => 'integer',
            'validate' => 'Core\Validation::required'
        ];
        $this->fields['ats_aceito'] = [
            'type' => 'boolean',
            'nullable' => true
        ];
        $this->fields['ats_data_atendimento'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::datetime'
        ];
    }

    function getByMedico($med_primary) {
        $this->validate([
            'ats_id_MEDICO' => $med_primary
        ]);
        return Database::getQueryBuilder()
            ->table($this->table)
            ->select()
            ->where('ats_id_MEDICO', '=', $med_primary)
            ->whereNull('ats_aceito')
            ->get();
    }

    function getByPaciente($pac_primary) {
        $this->validate([
            'ats_id_PACIENTE' => $pac_primary
        ]);
        return Database::getQueryBuilder()
            ->table($this->table)
            ->select()
            ->where('ats_id_PACIENTE', '=', $pac_primary)
            ->whereNull('ats_aceito')
            ->get();
    }

}