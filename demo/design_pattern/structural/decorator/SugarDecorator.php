<?php

namespace structural\decorator;
require_once "BeverageDecorator.php";
class SugarDecorator extends BeverageDecorator {
    public function getDescription() {
        return $this->beverage->getDescription() . ", Sugar";
    }

    public function cost() {
        return $this->beverage->cost() + 0.3;  // Ajoute 0.3 pour le sucre
    }
}
