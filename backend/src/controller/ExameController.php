<?php

namespace Controller;

use Core\Controller;
use Model\Exame;
use Model\Medico;
use Model\Paciente;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class ExameController extends Controller {

    public function __construct() {
        parent::$model = new Exame;
    }

    public function getByPaciente(Request $request, Response $response, $args) {

        $result = array_map(function ($exame) {
            $exame['paciente'] = (new Paciente)->get($exame['paciente']);
            $exame['medico'] = (new Medico)->get($exame['medico']);
            return $exame;
        }, self::$model->getByPaciente($args['id']));

        return $this->makeResponse($response, [
            'message' => 'Dados recuperados com sucesso',
            'body' => $result ?? []
        ]);

    }

    public function getByMedico(Request $request, Response $response, $args) {
        
        $result = array_map(function ($exame) {
            $exame['paciente'] = (new Paciente)->get($exame['paciente']);
            $exame['medico'] = (new Medico)->get($exame['medico']);
            return $exame;
        }, self::$model->getByMedico($args['id']));

        return $this->makeResponse($response, [
            'message' => 'Dados recuperados com sucesso',
            'body' => $result ?? []
        ]);

    }

}