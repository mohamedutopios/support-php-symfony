<?php

namespace strategy;

require_once "ShippingStrategy.php";

class SeaShipping implements ShippingStrategy
{
    public function calculate(float $weight): float
    {
        return $weight * 1.0; // Tarification par kilogramme
    }
}