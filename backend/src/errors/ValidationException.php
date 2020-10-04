<?php

namespace Errors;

class ValidationException extends DefaultException {

    public function __construct($message = "Erro de validação", $code = 400, DefaultException $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}