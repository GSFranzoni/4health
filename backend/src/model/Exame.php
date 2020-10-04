<?php

namespace Model;

use Core\Database;
use Core\Model;

class Exame extends Model {

    function __construct() {

        $this->table = 'TBL_EXAME';

        parent::$primary_key = "exa_id";

        parent::$fields['exa_id'] = [
            'type' => 'int'
        ];
        parent::$fields['exa_id_ATENDIMENTO'] = [
            'type' => 'int',
            'validate' => 'Core\Validation::required'
        ];
        parent::$fields['exa_nome'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        parent::$fields['exa_resultado'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        parent::$fields['exa_laudo'] = [
            'type' => 'string'
        ];
        parent::$fields['exa_data'] = [
            'type' => 'string'
        ];
    }

    public function get_by_paciente($pac_id) {
        return Database::getQueryBuilder()
            ->table(parent::$table)
            ->select(parent::$table. ".*")
            ->join(AtendimentoSolicitacao::$table, AtendimentoSolicitacao::$primary_key, "=", parent::$primary_key)
            ->get();  
            
    }

}