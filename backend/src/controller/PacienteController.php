<?php

namespace Controller;

use Core\Controller;
use Errors\DefaultException;
use Model\Paciente;
use Model\Usuario;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class PacienteController extends Controller {

    public function __construct() {
        parent::$model = new Paciente;
    }

}