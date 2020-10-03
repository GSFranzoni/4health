<?php

namespace Middlewares;

use Exception;
use Firebase\JWT\JWT;
use Throwable;

class CheckToken
{
    public static function run($token, $tipo_usuario)
    {
        try {
            $decoded = (array) JWT::decode($token, getenv('secret'), array('HS256'));
            
            if($decoded['usr_id_TIPO_USUARIO'] != $tipo_usuario) {
                throw new Exception("Acesso não autorizado");
            }
        }
        catch(Throwable $t) {
            throw new Exception("Acesso não autorizado");
        }
    }
}