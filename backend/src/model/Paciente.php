<?php

namespace Model;

use ClanCats\Hydrahon\Query\Sql\Func;
use Core\Database;
use Core\Model;
use Errors\DefaultException;
use PDOException;

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
            'telefone' => hash_hmac('ripemd160', $paciente['telefone'], getenv('secret')),
        ];
        return Database::getQueryBuilder()
            ->table($this->table)
            ->update($paciente_anonimo)
            ->where($this->primary_key, '=', $id)
            ->execute();
    }

    public function delete($primary) {

        if($this->countSolicitacoes($primary) > 0) {
            throw new DefaultException("O paciente possui solicitações de atendimento cadastradas.", 400);
        } 

        if($this->countExames($primary) > 0) {
            throw new DefaultException("O paciente possui exames cadastrados.", 400);
        } 

        parent::delete($primary);
    }

    public function countSolicitacoes($primary) {
        return (Database::getQueryBuilder()
            ->table('ATENDIMENTO_SOLICITACAO')
            ->select()
            ->addField(new Func('count', 'id'), 'count')
            ->where('paciente', $primary)
            ->execute())[0]['count'];
    }

    public function countExames($primary) {
        return (Database::getQueryBuilder()
            ->table('EXAME')
            ->select()
            ->addField(new Func('count', 'id'), 'count')
            ->where('paciente', $primary)
            ->execute())[0]['count'];
    }

}