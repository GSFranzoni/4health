<?php

namespace Controller;

use Core\Controller;
use Errors\DefaultException;
use Errors\UnauthorizedException;
use Exception;
use Firebase\JWT\JWT;
use Model\Paciente;
use Model\Usuario;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class PacienteController extends Controller {

    public function __construct() {
        parent::$model = new Paciente;
    }

    public function anonimizar(Request $request, Response $response, $args) {
        $usuario = null;
        try {
            $token = $request->getHeader('Authorization')[0] ?? "";
            $usuario = (array) JWT::decode($token, getenv('secret'), array('HS256'));
        }
        catch(Exception $e) {
            throw new UnauthorizedException();
        }

        $paciente = self::$model->getByUsuario($usuario['id']);
        $usuario = (new Usuario)->get($usuario['id']);

        if(!$paciente) {
            throw new DefaultException("A chave informada não corresponde à nenhum registro!", 400);
        }

        if($usuario['tipo_usuario'] != 3) {
            throw new DefaultException("Token inválido!", 401);
        }

        self::$model->anonimizar($paciente['id'], $paciente);
        (new Usuario)->anonimizar($usuario['id'], $usuario);
        (new Usuario)->update($usuario['id'], [ 'ativo' => 0 ]);

        $json = json_encode([
            'message' => 'Registro deletado com sucesso'
        ]);
        $response->getBody()->write($json);
        return $response;
    }

}