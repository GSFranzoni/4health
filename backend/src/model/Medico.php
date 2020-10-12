<?php

namespace Model;

use ClanCats\Hydrahon\Query\Sql\Func;
use Core\Database;
use Core\Model;
use Core\Validation;
use Errors\DefaultException;

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

    public function delete($primary) {
        
        if($this->countSolicitacoes($primary) > 0) {
            throw new DefaultException("O médico possui solicitações de atendimento cadastradas.");
        } 

        if($this->countExames($primary) > 0) {
            throw new DefaultException("O médico possui exames cadastrados.");
        } 

        parent::delete($primary);
    }

    public function countSolicitacoes($primary) {
        return (Database::getQueryBuilder()
            ->table('ATENDIMENTO_SOLICITACAO')
            ->select()
            ->addField(new Func('count', 'id'), 'count')
            ->where('medico', $primary)
            ->execute())[0]['count'];
    }

    public function countExames($primary) {
        return (Database::getQueryBuilder()
            ->table('EXAME')
            ->select()
            ->addField(new Func('count', 'id'), 'count')
            ->where('medico', $primary)
            ->execute())[0]['count'];
    }

}