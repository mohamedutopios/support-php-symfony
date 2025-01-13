<?php

namespace other;
require_once "Vehicle.php";

class Car extends Vehicle {
    // Cette méthode va provoquer une erreur si décommentée
    // public function displayType() {
    //     echo "This is a car.\n";
    // }

    public function displayDetails() {
        echo "Car details: count is " . self::$count . "\n";
    }



}