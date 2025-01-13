<?php

namespace factory;

require_once "VehicleInterface.php";
require_once "Car.php";
require_once "Bike.php";
class VehicleFactory
{
    public static function create(string $type): VehicleInterface
    {
        return match ($type) {
            'car' => new Car(),
            'bike' => new Bike(),
            default => throw new Exception("Invalid vehicle type"),
        };
    }
}