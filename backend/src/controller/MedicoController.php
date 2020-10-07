<?php

namespace Controller;

use Core\Controller;
use Errors\DefaultException;
use Model\Medico as Medico;
use Model\Usuario;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class MedicoController extends Controller {

    public function __construct() {
        parent::$model = new Medico;
    }

    public function getDisponiveis(Request $request, Response $response, $args) {
        $result  = self::$model->getDisponiveis();
        $json = json_encode([
            'message' => 'Dados recuperados com sucesso',
            'body' => $result ?? []
        ]);
        $response->getBody()->write($json);
        return $response;
    }

}