<?php

namespace Controller;

use Core\Controller;
use Model\Medico as Medico;

class MedicoController extends Controller {

    public function __construct() {
        parent::$model = new Medico;
    }

}