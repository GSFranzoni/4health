<?php

namespace Controller;

use Core\Controller;
use Core\Database;
use DateTime;
use Errors\UnauthorizedException;
use Exception;
use Model\Usuario;
use \Firebase\JWT\JWT;
use Model\Medico;
use Model\Paciente;
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

        $usuario = parent::$model->getByCpf($data['cpf']);

        if(empty($usuario)) {
            throw new UnauthorizedException("O cpf informado não existe na base dados!");
        }

        if(!password_verify($data['senha'], $usuario['senha'])) {
            throw new UnauthorizedException("Cpf e senha não correspondem!");
        }

        $payload = array(
            "id" => $usuario['id'],
            "tipo_usuario" => $usuario['tipo_usuario'],
            "iat" => (new DateTime)->getTimestamp(),
            "exp" => (new DateTime)->getTimestamp() + getenv("exp")
        );

        unset($usuario['senha']);
        return $this->makeResponse($response, [
            'message' => 'Login efetuado com sucesso!',
            'token' => JWT::encode($payload, getenv("secret")),
            'usuario' => $usuario,
            'info' => $this->getInfo($usuario['tipo_usuario'], $usuario['id'])
        ]);
    }

    private function getInfo($tipo, $usr_id) {
        switch($tipo) {
            case TipoUsuario::MEDICO:
                return (new Medico)->getByUsuario($usr_id);
            case TipoUsuario::PACIENTE:
                return (new Paciente)->getByUsuario($usr_id);
            default:
                return [];
        }
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

        return $this->makeResponse($response, [
            'message' => 'Dados recuperados com sucesso!',
            'token' => $token,
            'usuario' => self::$model->get($payload['id']),
            'info' => $this->getInfo($payload['tipo_usuario'], $payload['id'])
        ]);
    }

    public function insertPaciente(Request $request, Response $response, $args) {
        
        $data = $request->getParsedBody();

        $data['tipo_usuario'] = TipoUsuario::PACIENTE;

        Database::getInstance()->beginTransaction();

        $id = self::$model->save($data);

        (new Paciente)->update($args['id'], ['usuario' => $id]);

        Database::getInstance()->commit();

        return $this->makeResponse($response, [
            'message' => 'Dados salvos com sucesso',
            'body' => [ 'id' => $id ]
        ]);

    }

    public function insertMedico(Request $request, Response $response, $args) {

        $data = $request->getParsedBody();

        $data['tipo_usuario'] = TipoUsuario::MEDICO;

        Database::getInstance()->beginTransaction();

        $id = self::$model->save($data);

        (new Medico)->update($args['id'], ['usuario' => $id]);

        Database::getInstance()->commit();

        return $this->makeResponse($response, [
            'message' => 'Dados salvos com sucesso',
            'body' => [ 'id' => $id ]
        ]);

    }
    
}