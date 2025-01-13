<?php


use strategy\AirShipping;
use strategy\RoadShipping;
use strategy\SeaShipping;
use strategy\ShippingCost;

require_once "ShippingCost.php";
require_once "AirShipping.php";
require_once "RoadShipping.php";
require_once "SeaShipping.php";

// Exemple d'utilisation
$shippingCost = new ShippingCost();

// Calcul par avion
$shippingCost->setStrategy(new AirShipping());
echo "Air shipping cost: " . $shippingCost->calculateCost(10) . " USD" . "\n";

// Calcul par mer
$shippingCost->setStrategy(new SeaShipping());
echo "Sea shipping cost: " . $shippingCost->calculateCost(10) . " USD" . "\n";

// Calcul par route
$shippingCost->setStrategy(new RoadShipping());
echo "Road shipping cost: " . $shippingCost->calculateCost(10) . " USD" . "\n";