<?php

namespace Routes;

use Core\Controller;
use Model\AtendimentoSolicitacao;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Model\Medico as Medico;

class AtendimentoSolicitacaoRoute {

    public function getByMedico(Request $request, Response $response, $args) {
        $response->getBody()->write((new Controller(AtendimentoSolicitacao::class))->get($args['id']));
        return $response;
    }

}