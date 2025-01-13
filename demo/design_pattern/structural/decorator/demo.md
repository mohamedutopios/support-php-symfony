Le design pattern **Decorator** est un modèle structurel qui permet d'ajouter de manière dynamique des responsabilités supplémentaires à un objet, sans modifier sa classe. Cela permet d'ajouter des fonctionnalités à des objets existants de manière flexible et sans perturber la structure du code.

### Exemple :

Imaginons que nous ayons une classe `Coffee` représentant une simple boisson. Nous allons utiliser le pattern **Decorator** pour ajouter des personnalisations comme du lait, du sucre, etc., tout en maintenant la possibilité de combiner ces personnalisations.

### Code PHP :

```php
<?php

// L'interface Beverage définit la méthode commune pour toutes les boissons
interface Beverage {
    public function getDescription();
    public function cost();
}

// La classe Coffee représente une boisson de base
class Coffee implements Beverage {
    public function getDescription() {
        return "Coffee";
    }

    public function cost() {
        return 2.0;  // Prix de base du café
    }
}

// Le décorateur de base, qui permet de conserver un objet Beverage et de lui ajouter des fonctionnalités
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

// Un décorateur qui ajoute du lait à une boisson
class MilkDecorator extends BeverageDecorator {
    public function getDescription() {
        return $this->beverage->getDescription() . ", Milk";
    }

    public function cost() {
        return $this->beverage->cost() + 0.5;  // Ajoute 0.5 pour le lait
    }
}

// Un décorateur qui ajoute du sucre à une boisson
class SugarDecorator extends BeverageDecorator {
    public function getDescription() {
        return $this->beverage->getDescription() . ", Sugar";
    }

    public function cost() {
        return $this->beverage->cost() + 0.3;  // Ajoute 0.3 pour le sucre
    }
}

// Exemple d'utilisation du pattern Decorator

// Créer une boisson de base (Café)
$coffee = new Coffee();

// Ajouter du lait au café
$coffeeWithMilk = new MilkDecorator($coffee);

// Ajouter du sucre au café avec lait
$coffeeWithMilkAndSugar = new SugarDecorator($coffeeWithMilk);

// Afficher la description et le coût de la boisson finale
echo "Description: " . $coffeeWithMilkAndSugar->getDescription() . "\n";
echo "Cost: $" . $coffeeWithMilkAndSugar->cost() . "\n";

?>
```

### Explication :

1. **Interface `Beverage`** : Cette interface définit les méthodes communes pour toutes les boissons. Elle a deux méthodes : `getDescription()` pour obtenir une description de la boisson et `cost()` pour obtenir son coût.

2. **Classe `Coffee`** : Cette classe représente une boisson de base (un café) qui implémente l'interface `Beverage`. La méthode `getDescription()` renvoie "Coffee" et la méthode `cost()` renvoie 2.0 (prix de base du café).

3. **Classe `BeverageDecorator`** : Cette classe abstraite est un décorateur de base qui implémente l'interface `Beverage`. Elle prend un objet `Beverage` en paramètre et ajoute une couche supplémentaire de fonctionnalités sans modifier l'objet de base. Les décorateurs spécifiques (comme `MilkDecorator` et `SugarDecorator`) hériteront de cette classe.

4. **Classes `MilkDecorator` et `SugarDecorator`** : Ces classes décorent l'objet `Beverage` en ajoutant du lait et du sucre respectivement. Chaque décorateur modifie la méthode `getDescription()` pour ajouter une description et `cost()` pour augmenter le prix.

### Sortie attendue :

```
Description: Coffee, Milk, Sugar
Cost: $2.8
```

### Conclusion :

Le **Design Pattern Decorator** permet d'ajouter de manière flexible et dynamique des comportements supplémentaires à un objet, sans modifier sa classe de base. Cela permet une extensibilité et une maintenance plus facile, tout en conservant une interface uniforme pour l'objet de base et ses décorations.