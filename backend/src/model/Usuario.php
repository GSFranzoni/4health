<?php

namespace Model;

use Core\Database;
use Core\Model;
use Errors\UnauthorizedException;

class Usuario extends Model
{

    function __construct()
    {

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
            'type' => 'boolean',
            'hidden' => true,
            'nullable' => true
        ];
        $this->fields['tipo_usuario'] = [
            'type' => 'integer',
            'validate' => 'Core\Validation::required'
        ];
    }

    public function getByCpf($cpf)
    {
        $this->validate([
            'cpf' => $cpf
        ]);
        return Database::getQueryBuilder()
            ->table($this->table)
            ->select()
            ->where('cpf', $cpf)
            ->where('ativo', '=', true)
            ->get()[0];
    }

    public function anonimizar($id, $usuario)
    {
        $usuario_anonimo = [
            'cpf' => hash_hmac('ripemd160', $usuario['cpf'], getenv('secret'))
        ];
        return Database::getQueryBuilder()
            ->table($this->table)
            ->update($usuario_anonimo)
            ->where($this->primary_key, '=', $id)
            ->execute();
    }

    public function save($usuario)
    {
        $usuario['senha'] = password_hash($usuario['senha'], PASSWORD_DEFAULT);
        return parent::save($usuario);
    }

    public function update($primary, $usuario)
    {
        $usuario['senha'] = password_hash($usuario['senha'], PASSWORD_DEFAULT);
        return parent::update($primary, $usuario);
    }

}
