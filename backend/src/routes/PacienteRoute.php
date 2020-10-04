<?php

namespace Routes;

use Core\Controller;
use Model\Paciente;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class PacienteRoute {

    public function get(Request $request, Response $response, $args) {
        $response->getBody()->write((new Controller(Paciente::class))->get($args['id']));
        return $response;
    }

    public function getAll(Request $request, Response $response, $args) {
        $response->getBody()->write((new Controller(Paciente::class))->getAll());
        return $response;
    }

    public function insert(Request $request, Response $response, $args) {
        $body = $request->getParsedBody();
        $response->getBody()->write((new Controller(Paciente::class))->insert($body));
        return $response;
    }

}