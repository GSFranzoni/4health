<?php

namespace Controller;

use Core\Controller;
use Core\Database;
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
        
        return $this->makeResponse($response, [
            'message' => 'Dados recuperados com sucesso',
            'body' => self::$model->getDisponiveis() ?? []
        ]);
        
    }

    public function delete(Request $request, Response $response, $args) {

        $medico = self::$model->get($args['id']);

        if(!$medico) {
            throw new DefaultException("Registro não encontrado!", 400);
        }

        Database::getInstance()->beginTransaction();

        self::$model->delete($args['id']);
        (new Usuario)->delete($medico['usuario']);

        Database::getInstance()->commit();

        return $this->makeResponse($response, [
            'message' => 'Dados deletados com sucesso'
        ]);

    }

}