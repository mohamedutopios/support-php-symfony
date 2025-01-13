<?php

namespace factory;
require_once "VehicleInterface.php";
class Car implements VehicleInterface
{
    public function getType(): string
    {
        return "Car";
    }
}