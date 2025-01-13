<?php

namespace structural\decorator;

require_once "Coffee.php";
require_once "MilkDecorator.php";
require_once "SugarDecorator.php";

// Créer une boisson de base (Café)
$coffee = new Coffee();
echo "Coffee Simple: Description: " . $coffee->getDescription(). "\n";
echo "Cost: $" . $coffee->cost() . "\n";
// Ajouter du lait au café
$coffeeWithMilk = new MilkDecorator($coffee);
echo "CoffeeMilk: Description: " . $coffeeWithMilk->getDescription(). "\n";
echo "Cost: $" . $coffeeWithMilk->cost() . "\n";
// Ajouter du sucre au café avec lait
$coffeeWithMilkAndSugar = new SugarDecorator($coffeeWithMilk);
// Afficher la description et le coût de la boisson finale
echo "Description: " . $coffeeWithMilkAndSugar->getDescription() . "\n";
echo "Cost: $" . $coffeeWithMilkAndSugar->cost() . "\n";