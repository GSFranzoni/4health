<?php

namespace Controller;

use Core\Controller;
use Errors\DefaultException;
use Model\Medico as Medico;
use Model\Usuario;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

class MedicoController extends Controller {

    public function __construct() {
        parent::$model = new Medico;
    }

}