<?php

namespace strategy;

require_once "ShippingStrategy.php";
class RoadShipping implements ShippingStrategy
{
    public function calculate(float $weight): float
    {
        return $weight * 0.8; // Tarification par kilogramme
    }
}