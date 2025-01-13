<?php

use factory\VehicleFactory;
require_once "VehicleFactory.php";

$car = VehicleFactory::create('car');
echo $car->getType(); // Output: Car
echo "\n";
$bike = VehicleFactory::create('bike');
echo $bike->getType(); // Output: Bike