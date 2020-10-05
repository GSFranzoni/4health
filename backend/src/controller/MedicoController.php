<?php

namespace Controller;

use Core\Controller;
use Model\Medico as Medico;
use Model\Usuario;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class MedicoController extends Controller {

    public function __construct() {
        parent::$model = new Medico;
    }

    public function getAll(Request $request, Response $response, $args) {
        $result  = self::$model->getAll();
        foreach ($result as &$row) {
            $usuario = (new Usuario)->get($row['med_id_USUARIO'])[0];
            $row['med_usuario'] = $usuario;
            unset($row['med_id_USUARIO']);
        }
        $json = json_encode([
            'message' => 'Dados recuperados com sucesso',
            'body' => $result ?? []
        ]);
        $response->getBody()->write($json);
        return $response;
    }

}