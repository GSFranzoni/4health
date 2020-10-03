<?php

namespace Controller;

use Dao\UsuarioDao;
use Exception;
use Model\Usuario;
use \Firebase\JWT\JWT;

class UsuarioController {

    public function login($cpf, $senha) {
        $result = (new UsuarioDao())->get_by_cpf($cpf, $senha);
        if(empty($result)) {
            throw new Exception('Cpf e senha não correspondem!');
        }
        $payload = array(
            "usr_id" => $result['usr_id'],
            "usr_id_TIPO_USUARIO" => $result['usr_id_TIPO_USUARIO']
        );
        JWT::$leeway = 2592000;
        $jwt = JWT::encode($payload, getenv("secret"));
        return json_encode([
            'message' => 'Login efetuado com sucesso!',
            'token' => $jwt,
            'usuario' => (new UsuarioDao())->get($result['usr_id'])
        ]);
    }

    public function me($jwt) {
        $payload = (array) JWT::decode($jwt, getenv('secret'), array('HS256'));
        return json_encode([
            'message' => 'Login efetuado com sucesso!',
            'token' => $jwt,
            'usuario' => (new UsuarioDao())->get($payload['usr_id'])
        ]);
    }

}