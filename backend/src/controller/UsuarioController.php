<?php

namespace Controller;

use Core\Controller;
use Errors\UnauthorizedException;
use Exception;
use Model\Usuario;
use \Firebase\JWT\JWT;
use Model\TipoUsuario;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class UsuarioController extends Controller {

    public function __construct() {
        parent::$model = new Usuario;
    }

    public function login(Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $result = parent::$model->getByCpfSenha($data['cpf'], $data['senha'])[0];
        if(empty($result)) {
            throw new UnauthorizedException("Cpf e senha não correspondem!");
        }
        $payload = array(
            "id" => $result['id'],
            "tipo_usuario" => $result['tipo_usuario']
        );
        JWT::$leeway = 2592000;
        $jwt = JWT::encode($payload, getenv("secret"));
        $json = json_encode([
            'message' => 'Login efetuado com sucesso!',
            'token' => $jwt,
            'usuario' => $result
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
            'usuario' => parent::$model->get($payload['id'])
        ]);
        $response->getBody()->write($json);
        return $response;
    }

    public function getAll(Request $request, Response $response, $args) {
        $result  = self::$model->getAll();
        foreach ($result as &$row) {
            $row['tipo_usuario'] = (new TipoUsuario)->get($row['tipo_usuario'])[0];
        }
        $json = json_encode([
            'message' => 'Dados recuperados com sucesso',
            'body' => $result ?? []
        ]);
        $response->getBody()->write($json);
        return $response;
    }

}