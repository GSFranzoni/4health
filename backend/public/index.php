<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../src/config/app.php';


// use Model\Medico as Medico;
// use Core\Controller;
// use Core\Dao;

// $medico = new Medico();

// $dao = new Dao(Medico::class);

// $controller = new Controller();

// $medico->save([
//     'med_nome' => 'Gui',
//     'med_cpf' => '140.526.066.12',
//     'med_crm' => '235423',
//     'med_especialidade' => 'Neurologista',
//     'med_id_USUARIO' => 1
// ]);


// print $controller->get(1);

