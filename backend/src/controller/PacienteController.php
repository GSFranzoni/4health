<?php

namespace Controller;

use Core\Controller;
use Model\Paciente;

class PacienteController extends Controller {

    public function __construct() {
        parent::$model = new Paciente;
    }

}