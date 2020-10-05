<?php

namespace Model;

use Core\Database;
use Core\Model;

class Usuario extends Model {

    function __construct() {

        $this->table = 'USUARIO';

        $this->primary_key = "id";

        $this->fields['id'] = [
            'type' => 'integer'
        ];
        $this->fields['cpf'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::cpf' 
        ];
        $this->fields['senha'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::password',
            'hidden' => true 
        ];
        $this->fields['ativo'] = [
            'type' => 'boolean'
        ];
        $this->fields['tipo_usuario'] = [
            'type' => 'integer',
            'validate' => 'Core\Validation::required' 
        ];
    }

    public function getByCpfSenha($cpf, $senha) {
        $this->validate([
            'cpf' => $cpf,
            'senha' => $senha
        ]);
        return Database::getQueryBuilder()
            ->table($this->table)
            ->select()
            ->where('cpf', $cpf)
            ->where('senha', $senha)
            ->get();  
    }

}