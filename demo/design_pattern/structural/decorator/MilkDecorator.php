<?php

namespace structural\decorator;

require_once "BeverageDecorator.php";
// Un décorateur qui ajoute du lait à une boisson
class MilkDecorator extends BeverageDecorator {
    public function getDescription() {
        return $this->beverage->getDescription() . ", Milk";
    }

    public function cost() {
        return $this->beverage->cost() + 0.5;  // Ajoute 0.5 pour le lait
    }
}