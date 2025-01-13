<?php

namespace other;

require_once "Car.php";
require_once "Vehicle.php";

$vehicle1 = new Vehicle();
$vehicle1->log("Vehicle 1 created."); // Utilisation du trait Logger
echo "Vehicle count: " . Vehicle::getCount() . "\n";

$vehicle2 = new Vehicle();
$vehicle2->log("Vehicle 2 created."); // Utilisation du trait Logger
echo "Vehicle count: " . Vehicle::getCount() . "\n";

// Création d'un objet de la classe Car
$car = new Car();
$car->log("Car created.");
$car->displayDetails(); // Utilisation de la méthode redéfinie

$vehicle1->displayType();
