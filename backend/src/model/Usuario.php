<?php

namespace Model;

use Core\Database;
use Core\Model;

class Usuario extends Model {

    function __construct() {

        $this->table = 'TBL_USUARIO';

        $this->primary_key = "usr_id";

        $this->fields['usr_id'] = [
            'type' => 'integer'
        ];
        $this->fields['usr_cpf'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::cpf' 
        ];
        $this->fields['usr_senha'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::password',
            'hidden' => true 
        ];
        $this->fields['usr_ativo'] = [
            'type' => 'boolean'
        ];
        $this->fields['usr_id_TIPO_USUARIO'] = [
            'type' => 'integer',
            'validate' => 'Core\Validation::required' 
        ];
    }

    public function getByCpfSenha($cpf, $senha) {
        $this->validate([
            'usr_cpf' => $cpf,
            'usr_senha' => $senha
        ]);
        return Database::getQueryBuilder()
            ->table($this->table)
            ->select()
            ->where('usr_cpf', $cpf)
            ->where('usr_senha', $senha)
            ->get();  
    }

}