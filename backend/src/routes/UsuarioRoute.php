<?php

namespace Routes;

use Controller\UsuarioController;
use Core\Controller;
use Model\Usuario;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UsuarioRoute {

    public function get(Request $request, Response $response, $args) {
        $response->getBody()->write((new Controller(Usuario::class))->get($args['id']));
        return $response;
    }

    public function getAll(Request $request, Response $response, $args) {
        $response->getBody()->write((new Controller(Usuario::class))->getAll());
        return $response;
    }

    public function insert(Request $request, Response $response, $args) {
        $body = $request->getParsedBody();
        $response->getBody()->write((new Controller(Usuario::class))->insert($body));
        return $response;
    }

    public function login(Request $request, Response $response, $args) {
        $cpf = $request->getParsedBody()['cpf'] ?? null;
        $senha = $request->getParsedBody()['senha'] ?? null;
        $response->getBody()->write((new UsuarioController())->login($cpf, $senha));
        return $response;
    }

    public function me(Request $request, Response $response, $args) {
        $token = $request->getParsedBody()['token'] ?? null;
        $response->getBody()->write((new UsuarioController())->me($token));
        return $response;
    }
}