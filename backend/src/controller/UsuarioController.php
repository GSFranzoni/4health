<?php

namespace Controller;

use Core\Controller;
use Errors\UnauthorizedException;
use Exception;
use Model\Usuario;
use \Firebase\JWT\JWT;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class UsuarioController extends Controller {

    public function __construct() {
        parent::$model = new Usuario;
    }

    public function login(Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $result = parent::$model->get_by_cpf_e_senha($data['usr_cpf'], $data['usr_senha'])[0];
        if(empty($result)) {
            throw new UnauthorizedException("Cpf e senha não correspondem!");
        }
        $payload = array(
            "usr_id" => $result['usr_id'],
            "usr_id_TIPO_USUARIO" => $result['usr_id_TIPO_USUARIO']
        );
        JWT::$leeway = 2592000;
        $jwt = JWT::encode($payload, getenv("secret"));
        $json = json_encode([
            'message' => 'Login efetuado com sucesso!',
            'token' => $jwt,
            'usuario' => parent::$model->get($result['usr_id'])
        ]);
        $response->getBody()->write($json);
        return $response;
    }

    public function me(Request $request, Response $response, $args) {
        $token = $request->getParsedBody()['token'];
        $payload = null;
        try {
            $payload = (array) JWT::decode($token, getenv('secret'), array('HS256'));
        }
        catch(Exception $e) {
            throw new UnauthorizedException();
        }
        $json = json_encode([
            'message' => 'Dados recuperados com sucesso!',
            'token' => $token,
            'usuario' => parent::$model->get($payload['usr_id'])
        ]);
        $response->getBody()->write($json);
        return $response;
    }

}