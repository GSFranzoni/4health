<?php

namespace Controller;

use Core\Controller;
use Core\Database;
use Errors\DefaultException;
use Errors\UnauthorizedException;
use Exception;
use Firebase\JWT\JWT;
use Model\Paciente;
use Model\TipoUsuario;
use Model\Usuario;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class PacienteController extends Controller {

    public function __construct() {
        parent::$model = new Paciente;
    }

    public function anonimizar(Request $request, Response $response, $args) {

        $token = $request->getHeader('Authorization')[0] ?? "";
        $payload = (array) JWT::decode($token, getenv('secret'), array('HS256'));
        $usuario = (new Usuario)->get($payload['id']);
        
        $paciente = self::$model->getByUsuario($usuario['id']);
        if(!$paciente) {
            throw new DefaultException("A chave informada não corresponde à nenhum registro!", 400);
        }

        if($usuario['tipo_usuario'] != TipoUsuario::PACIENTE) {
            throw new DefaultException("Token inválido!", 401);
        }
        
        Database::getInstance()->beginTransaction();

        self::$model->anonimizar($paciente['id'], $paciente);

        (new Usuario)->anonimizar($usuario['id'], $usuario);

        Database::getInstance()->commit();

        return $this->makeResponse($response, [
            'message' => 'Registro deletado com sucesso'
        ]);
        
    }

    public function delete(Request $request, Response $response, $args) {

        $paciente = self::$model->get($args['id']);

        if(!$paciente) {
            throw new DefaultException("Registro não encontrado!", 400);
        }

        Database::getInstance()->beginTransaction();

        self::$model->delete($args['id']);
        (new Usuario)->delete($paciente['usuario']);

        Database::getInstance()->commit();

        return $this->makeResponse($response, [
            'message' => 'Dados deletados com sucesso'
        ]);

    }

}