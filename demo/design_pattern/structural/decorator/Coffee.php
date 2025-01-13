<?php

namespace structural\decorator;

require_once "Beverage.php";

class Coffee implements Beverage {
    public function getDescription() {
        return "Coffee";
    }

    public function cost() {
        return 2.0;  // Prix de base du café
    }
}