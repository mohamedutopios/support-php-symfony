<?php

namespace exception\demo2;

class DivisionByZeroException extends \Exception {
    public function __construct($message = "Erreur de division par zéro", $code = 0) {
        parent::__construct($message, $code);
    }
}