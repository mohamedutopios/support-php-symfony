<?php

namespace other;

require_once "Logger.php";

class Vehicle {
    use Logger;  // Utilisation du trait Logger

    public static $count = 0;  // Propriété statique pour compter les instances

    // Constructeur
    public function __construct() {
        self::$count++;
    }

    // Méthode statique
    public static function getCount() {
        return self::$count;
    }

    // Méthode finale (ne peut pas être redéfinie)
    final public function displayType() {
        echo "This is a vehicle.\n";
    }

    // Méthode à redéfinir (non finale)
    public function displayDetails() {
        echo "Vehicle details: count is " . self::$count . "\n";
    }


}