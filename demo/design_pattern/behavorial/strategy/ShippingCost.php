<?php

namespace strategy;

require_once "ShippingStrategy.php";
class ShippingCost
{
    private ShippingStrategy $strategy;

    public function setStrategy(ShippingStrategy $strategy): void
    {
        $this->strategy = $strategy;
    }

    public function calculateCost(float $weight): float
    {
        return $this->strategy->calculate($weight);
    }
}