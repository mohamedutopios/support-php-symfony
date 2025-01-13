<?php

namespace factory;
require_once "VehicleInterface.php";
class Bike implements VehicleInterface
{
    public function getType(): string
    {
        return "Bike";
    }
}