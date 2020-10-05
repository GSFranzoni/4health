<?php

namespace Controller;

use Core\Controller;
use Model\Paciente;
use Model\Usuario;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class PacienteController extends Controller {

    public function __construct() {
        parent::$model = new Paciente;
    }

    public function getAll(Request $request, Response $response, $args) {
        $result  = self::$model->getAll();
        foreach ($result as &$row) {
            $usuario = (new Usuario)->get($row['pac_id_USUARIO'])[0];
            $row['pac_usuario'] = $usuario;
            unset($row['pac_id_USUARIO']);
        }
        $json = json_encode([
            'message' => 'Dados recuperados com sucesso',
            'body' => $result ?? []
        ]);
        $response->getBody()->write($json);
        return $response;
    }

}