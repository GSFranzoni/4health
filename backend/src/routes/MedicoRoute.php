<?php

namespace Routes;

use Core\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Model\Medico as Medico;

class MedicoRoute {

    public function get(Request $request, Response $response, $args) {
        $response->getBody()->write((new Controller(Medico::class))->get($args['id']));
        return $response;
    }

    public function getAll(Request $request, Response $response, $args) {
        $response->getBody()->write((new Controller(Medico::class))->getAll());
        return $response;
    }

    public function insert(Request $request, Response $response, $args) {
        $body = $request->getParsedBody();
        $response->getBody()->write((new Controller(Medico::class))->insert($body));
        return $response;
    }

}