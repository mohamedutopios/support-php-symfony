<?php

namespace exception\demo2;

require_once "DivisionByZeroException.php";

try {
    $dividend = 10;
    $divisor = 0;

    if ($divisor == 0) {
        throw new DivisionByZeroException();
    }
    $result = $dividend / $divisor;

} catch (DivisionByZeroException $e) {
    echo "Exception spécifique : " . $e->getMessage();
} catch (Exception $e) {
    echo "Exception générale : " . $e->getMessage();
}