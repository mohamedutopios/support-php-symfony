<?php

namespace structural\decorator;

require_once "Beverage.php";
abstract class BeverageDecorator implements Beverage {
    protected $beverage;

    public function __construct(Beverage $beverage) {
        $this->beverage = $beverage;
    }

    // Les classes décoratrices doivent implémenter les méthodes de l'interface Beverage
    public function getDescription() {
        return $this->beverage->getDescription();
    }

    public function cost() {
        return $this->beverage->cost();
    }
}