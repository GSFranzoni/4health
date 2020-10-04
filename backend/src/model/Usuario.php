<?php

namespace Model;

use Core\Database;
use Core\Model;

class Usuario extends Model {

    function __construct() {

        parent::$table = 'TBL_USUARIO';

        parent::$primary_key = "usr_id";

        parent::$fields['usr_id'] = [
            'type' => 'int'
        ];
        parent::$fields['usr_cpf'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::cpf' 
        ];
        parent::$fields['usr_senha'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required',
            'hidden' => true 
        ];
        parent::$fields['usr_ativo'] = [
            'type' => 'boolean',
            'validate' => 'Core\Validation::required' 
        ];
        parent::$fields['usr_id_TIPO_USUARIO'] = [
            'type' => 'int',
            'validate' => 'Core\Validation::required' 
        ];
    }

    public function get_by_cpf_e_senha($cpf, $senha) {
        $this->validate([
            'usr_cpf' => $cpf,
            'usr_senha' => $senha
        ]);
        return Database::getQueryBuilder()
            ->table(parent::$table)
            ->select()
            ->where('usr_cpf', $cpf)
            ->where('usr_senha', $senha)
            ->get();  
    }

}