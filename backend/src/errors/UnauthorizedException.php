<?php

namespace Errors;

class UnauthorizedException extends DefaultException {

    public function __construct($message = "Não existe uma sessão para seu usuário", $code = 401, DefaultException $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}