<?php

namespace Controller;

use Core\Controller;
use Errors\DefaultException;
use Model\AtendimentoSolicitacao;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class AtendimentoSolicitacaoController extends Controller {

    public function __construct() {
        parent::$model = new AtendimentoSolicitacao();
    }

    public function getByMedico(Request $request, Response $response, $args) {
        
        return $this->makeResponse($response, [
            'message' => 'Dados recuperados com sucesso',
            'body' => self::$model->getByMedico($args['id']) ?? []
        ]);

    }

    public function insert(Request $request, Response $response, $args) {

        $body = $request->getParsedBody();

        if(!empty(self::$model->getByMedico($body['medico']))) {
            throw new DefaultException("O médico possui uma solicitação de atendimento pendente.", 400);
        }

        if(!empty(self::$model->getByPaciente($body['paciente']))) {
            throw new DefaultException("O paciente possui uma solicitação de atendimento pendente.", 400);
        }
        
        return parent::insert($request, $response, $args);
    }
    
}