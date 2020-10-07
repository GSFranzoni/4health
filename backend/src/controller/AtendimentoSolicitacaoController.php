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
        $result  = self::$model->getByMedico($args['id']);
        $json = json_encode([
            'message' => 'Dados recuperados com sucesso',
            'body' => $result ?? []
        ]);
        $response->getBody()->write($json);
        return $response;
    }

    public function insert(Request $request, Response $response, $args) {
        $data = $request->getParsedBody();
        $by_medico = self::$model->getByMedico($data['medico']);
        $by_paciente = self::$model->getByPaciente($data['paciente']);
        if(!empty($by_medico)) {
            throw new DefaultException("O médico possui uma solicitação de atendimento pendente.", 400);
        }
        if(!empty($by_paciente)) {
            throw new DefaultException("O paciente possui uma solicitação de atendimento pendente.", 400);
        }
        $id = self::$model->save($data);
        $json = json_encode([
            'message' => 'Dados salvos com sucesso',
            'body' => [ 'id' => $id ]
        ]);
        $response->getBody()->write($json);
        return $response;
    }
    
}