<?php

namespace Model;

use Core\Database;
use Core\Model;
use Core\Validation;

class Medico extends Model {

    function __construct() {

        $this->table = 'MEDICO';

        $this->primary_key = "id";

        $this->fields['id'] = [
            'type' => 'integer'
        ];
        $this->fields['nome'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required' 
        ];
        $this->fields['crm'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required' 
        ];
        $this->fields['especialidade'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required' 
        ];
        $this->fields['usuario'] = [
            'type' => 'integer',
            'nullable' => true
        ];
    }

    public function getByUsuario($usr_id) {
        return Database::getQueryBuilder()
            ->table($this->table)
            ->select($this->keys())
            ->where('usuario', $usr_id)
            ->get()[0];  
    }

    public function getDisponiveis() {
        $query = "SELECT * FROM MEDICO WHERE id NOT IN (
                    SELECT DISTINCT medico
                    FROM ATENDIMENTO_SOLICITACAO
                    WHERE aceito IS NULL);";
        return Database::query($query);
    }

}