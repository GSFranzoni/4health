<?php

namespace Routes;

use Core\Controller;
use Model\TipoUsuario;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TipoUsuarioRoute {

    public function get(Request $request, Response $response, $args) {
        $response->getBody()->write((new Controller(TipoUsuario::class))->get($args['id']));
        return $response;
    }

    public function getAll(Request $request, Response $response, $args) {
        $response->getBody()->write((new Controller(TipoUsuario::class))->getAll());
        return $response;
    }

}