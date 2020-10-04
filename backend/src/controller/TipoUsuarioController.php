<?php

namespace Controller;

use Core\Controller;
use Model\TipoUsuario;

class TipoUsuarioController extends Controller {

    public function __construct() {
        parent::$model = new TipoUsuario;
    }

}