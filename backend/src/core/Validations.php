<?php

namespace Core;

class Validation {

    public static function cpf($data) {
        return (new \Bissolli\ValidadorCpfCnpj\CPF($data))->isValid();
    }

    public static function required($data) {
        return !empty($data);
    }

    public static function type($data, $type) {
        return gettype($data)==$type;
    }
}