<?php

namespace exception\demo1;

try {
    // Code qui peut générer une exception
    $dividend = 10;
    $divisor = 0;

    if ($divisor == 0) {
        throw new \Exception("Division par zéro"); // Utilisation de la classe Exception native
    }
    $result = $dividend / $divisor;

} catch (\Exception $e) {
    echo "Erreur : " . $e->getMessage();
}



