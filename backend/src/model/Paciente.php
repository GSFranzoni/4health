<?php

namespace Model;

use Core\Database;
use Core\Model;

class Paciente extends Model {

    function __construct() {

        $this->table = 'PACIENTE';

        $this->primary_key = "id";

        $this->fields['id'] = [
            'type' => 'integer'
        ];
        $this->fields['nome'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        $this->fields['uf'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        $this->fields['cidade'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        $this->fields['logradouro'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        $this->fields['bairro'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        $this->fields['numero_casa'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required'
        ];
        $this->fields['telefone'] = [
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

    public function anonimizar($id, $paciente) {
        $paciente_anonimo = [
            'nome' => hash_hmac('ripemd160', $paciente['nome'], getenv('secret')),
            'uf' => hash_hmac('ripemd160', $paciente['uf'], getenv('secret')),
            'cidade' => hash_hmac('ripemd160', $paciente['cidade'], getenv('secret')),
            'logradouro' => hash_hmac('ripemd160', $paciente['logradouro'], getenv('secret')),
            'bairro' => hash_hmac('ripemd160', $paciente['bairro'], getenv('secret')),
            'numero_casa' => hash_hmac('ripemd160', $paciente['numero_casa'], getenv('secret')),
            'telefone' => '(00) 0 0000-0000'
        ];
        return Database::getQueryBuilder()
            ->table($this->table)
            ->update($paciente_anonimo)
            ->where($this->primary_key, '=', $id)
            ->execute();
    }

}