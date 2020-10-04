<?php

namespace Model;

use Core\Database;
use Core\Model;

class AtendimentoSolicitacao extends Model {

    static $table = 'TBL_ATENDIMENTO_SOLICITACAO';

    static $primary_key = "ats_id";

    function __construct() {

        parent::$fields['ats_id'] = [
            'type' => 'int'
        ];
        parent::$fields['ats_id_PACIENTE'] = [
            'type' => 'int',
            'validate' => 'Core\Validation::required'
        ];
        parent::$fields['ats_id_MEDICO'] = [
            'type' => 'int',
            'validate' => 'Core\Validation::required'
        ];
        parent::$fields['ats_aceito'] = [
            'type' => 'boolean'
        ];
    }

    function get_by_med($med_primary) {
        return Database::getQueryBuilder()
            ->table(parent::$table)
            ->select()
            ->where('ats_id_MEDICO', '=', $med_primary)
            ->get();
    }

}