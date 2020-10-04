<?php

namespace Controller;

use Core\Controller;
use Model\AtendimentoSolicitacao;

class AtendimentoSolicitacaoController extends Controller {

    public function __construct() {
        parent::$model = new AtendimentoSolicitacao();
    }

}