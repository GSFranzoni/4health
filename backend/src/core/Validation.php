<?php

namespace Core;

use DateTime;

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

    public static function datetime($date) {
        $format = 'Y-m-d H:i:s';
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public static function password(string $data) {
        return strlen($data) > 7;
    }
}