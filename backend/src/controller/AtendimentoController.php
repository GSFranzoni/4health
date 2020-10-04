<?php

namespace Controller;

use Core\Controller;
use Model\Atendimento;

class AtendimentoController extends Controller {

    public function __construct() {
        parent::$model = new Atendimento();
    }

}