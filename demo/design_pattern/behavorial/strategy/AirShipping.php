<?php

namespace strategy;

require_once 'ShippingStrategy.php';
class AirShipping implements ShippingStrategy
{
    public function calculate(float $weight): float
    {
        return $weight * 1.5; // Tarif par kilogramme
    }
}