<?php

namespace Model;

use Core\Model;
use Core\Validation;

class Medico extends Model {

    function __construct() {

        $this->table = 'TBL_MEDICO';

        $this->primary_key = "med_id";

        $this->fields['med_id'] = [
            'type' => 'int',
            'valite' => 'Core\Validation::required'
        ];
        $this->fields['med_nome'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required' 
        ];
        $this->fields['med_crm'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required' 
        ];
        $this->fields['med_especialidade'] = [
            'type' => 'string',
            'validate' => 'Core\Validation::required' 
        ];
        $this->fields['med_id_USUARIO'] = [
            'type' => 'integer',
            'validate' => 'Core\Validation::required' 
        ];
    }

}

// class Medico extends Model {

//     public $nome, $cpf, $crm, $especialidade, $usuario;

//     public function __construct($array = []) {
//         parent::__construct($array, "TBL_MEDICO");
//         $this->validations['cpf'] = 'Core\Validation::cpf';
//     }

//     public static function fields(): array {
//         return [ 
//             'id' => 'med_id', 
//             'nome' => 'med_nome',
//             'cpf' => 'med_cpf',
//             'crm' => 'med_crm',
//             'especialidade' => 'med_especialidade',
//             'usuario' => 'med_id_USUARIO'
//         ];
//     }
// }