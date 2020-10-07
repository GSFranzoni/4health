<?php

namespace Controller;

use Core\Controller;
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
        $data['senha'] = hash_hmac('ripemd160', $data['senha'], getenv('secret'));

        $result = parent::$model->getByCpfSenha($data['cpf'], $data['senha']);
        if(empty($result)) {
            throw new UnauthorizedException("Cpf e senha não correspondem!");
        }

        $payload = array(
            "id" => $result['id'],
            "tipo_usuario" => $result['tipo_usuario']
        );

        JWT::$leeway = getenv("leeway");
        $jwt = JWT::encode($payload, getenv("secret"));

        $json = json_encode([
            'message' => 'Login efetuado com sucesso!',
            'token' => $jwt,
            'usuario' => $result,
            'info' => $this->getInfo($result['tipo_usuario'], $result['id'])
        ]);
        $response->getBody()->write($json);
        return $response;
    }

    private function getInfo($tipo, $usr_id) {
        switch($tipo) {
            case 2:
                return (new Medico)->getByUsuario($usr_id);
            case 3:
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
        $json = json_encode([
            'message' => 'Dados recuperados com sucesso!',
            'token' => $token,
            'usuario' => parent::$model->get($payload['id']),
            'info' => $this->getInfo($payload['tipo_usuario'], $payload['id'])
        ]);
        $response->getBody()->write($json);
        return $response;
    }

    public function getAll(Request $request, Response $response, $args) {
        $result  = self::$model->getAll();
        foreach ($result as &$row) {
            $row['tipo_usuario'] = (new TipoUsuario)->get($row['tipo_usuario']);
        }
        $json = json_encode([
            'message' => 'Dados recuperados com sucesso',
            'body' => $result ?? []
        ]);
        $response->getBody()->write($json);
        return $response;
    }

    public function insertPaciente(Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $paciente_id = $args['id'];
        $data['tipo_usuario'] = 3;
        $data['senha'] = hash_hmac('ripemd160', $data['senha'], getenv('secret'));
        $id = self::$model->save($data);
        (new Paciente)->update($paciente_id, ['usuario' => $id]);
        $json = json_encode([
            'message' => 'Dados salvos com sucesso',
            'body' => [ 'id' => $id ]
        ]);
        $response->getBody()->write($json);
        return $response;
    }

    public function insertMedico(Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $medico_id = $args['id'];
        $data['tipo_usuario'] = 2;
        $data['senha'] = hash_hmac('ripemd160', $data['senha'], getenv('secret'));
        $id = self::$model->save($data);
        (new Medico)->update($medico_id, ['usuario' => $id]);
        $json = json_encode([
            'message' => 'Dados salvos com sucesso',
            'body' => [ 'id' => $id ]
        ]);
        $response->getBody()->write($json);
        return $response;
    }

}