<?php

namespace Dao;

use Exception;
use Model\Usuario;
use Core\Dao;
use Core\Database;
use PDO;

class UsuarioDao extends Dao {

    function __construct() {
        parent::__construct(Usuario::class);
    }

    public function get_by_cpf($cpf, $senha) {
        $sql = "SELECT * FROM TBL_USUARIO WHERE usr_cpf=:usr_cpf AND usr_senha=:usr_senha";
        $stmt = Database::getInstance()->prepare($sql);
        $stmt->bindParam(':usr_cpf', $cpf);
        $stmt->bindParam(':usr_senha', $senha);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}