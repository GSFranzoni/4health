<?php

namespace Controller;

use Core\Controller;
use Model\Exame;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class ExameController extends Controller {

    public function __construct() {
        parent::$model = new Exame();
    }

    public function get_by_paciente(Request $request, Response $response, $args) {
        $result  = self::$model->get_by_paciente();
        $json = json_encode([
            'message' => 'Dados recuperados com sucesso',
            'body' => $result ?? []
        ]);
        $response->getBody()->write($json);
        return $response;
    }

}