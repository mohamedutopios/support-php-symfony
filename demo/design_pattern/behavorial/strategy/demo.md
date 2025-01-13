Le **design pattern Strategy** est un pattern comportemental qui permet de définir une famille d'algorithmes, de les encapsuler dans des classes séparées et de les rendre interchangeables au moment de l'exécution. Cela permet de rendre le code plus flexible en séparant l'algorithme de la logique métier principale.

---

### **Cas d'usage**
Imaginons une application de calcul des frais de livraison. Les frais peuvent varier selon la méthode de livraison : par avion, par bateau ou par route. Chaque stratégie de calcul des frais sera encapsulée dans une classe séparée.

---

### **Implémentation en PHP**

#### **1. Interface de la stratégie**
Cette interface définit la méthode que toutes les stratégies doivent implémenter.

```php
<?php

interface ShippingStrategy
{
    public function calculate(float $weight): float;
}
```

---

#### **2. Stratégies concrètes**
Chaque classe implémente l'interface pour fournir une logique de calcul spécifique.

```php
<?php

class AirShipping implements ShippingStrategy
{
    public function calculate(float $weight): float
    {
        return $weight * 1.5; // Tarification par kilogramme
    }
}

class SeaShipping implements ShippingStrategy
{
    public function calculate(float $weight): float
    {
        return $weight * 1.0; // Tarification par kilogramme
    }
}

class RoadShipping implements ShippingStrategy
{
    public function calculate(float $weight): float
    {
        return $weight * 0.8; // Tarification par kilogramme
    }
}
```

---

#### **3. Contexte**
Le contexte utilise une stratégie pour effectuer le calcul sans se soucier des détails de l'implémentation.

```php
<?php

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
```

---

#### **4. Utilisation**
Voici un exemple complet d'utilisation du pattern Strategy.

```php
<?php

require_once 'ShippingStrategy.php';
require_once 'AirShipping.php';
require_once 'SeaShipping.php';
require_once 'RoadShipping.php';
require_once 'ShippingCost.php';

// Exemple d'utilisation
$shippingCost = new ShippingCost();

// Calcul par avion
$shippingCost->setStrategy(new AirShipping());
echo "Air shipping cost: " . $shippingCost->calculateCost(10) . " USD" . PHP_EOL;

// Calcul par mer
$shippingCost->setStrategy(new SeaShipping());
echo "Sea shipping cost: " . $shippingCost->calculateCost(10) . " USD" . PHP_EOL;

// Calcul par route
$shippingCost->setStrategy(new RoadShipping());
echo "Road shipping cost: " . $shippingCost->calculateCost(10) . " USD" . PHP_EOL;
```

---

### **Exécution**
1. Placez chaque classe dans un fichier séparé (comme dans l'exemple précédent).
2. Exécutez le script principal avec PHP.

---

### **Résultat attendu**
Pour un poids de 10 kg :
```
Air shipping cost: 15 USD
Sea shipping cost: 10 USD
Road shipping cost: 8 USD
```

---

### **Explication**

1. **Encapsulation des algorithmes** :
   Chaque stratégie (comme `AirShipping`, `SeaShipping`, ou `RoadShipping`) implémente l'interface `ShippingStrategy`. Cela permet de gérer facilement différents algorithmes de calcul.

2. **Flexibilité** :
   Le contexte (`ShippingCost`) peut changer de stratégie à la volée en appelant `setStrategy()`. Ainsi, il est possible d’ajouter ou de modifier une stratégie sans toucher au code existant.

3. **Réduction du couplage** :
   Le contexte n'a aucune connaissance des détails spécifiques des algorithmes. Il dépend uniquement de l'interface `ShippingStrategy`.

4. **Facilité de maintenance** :
   Ajouter une nouvelle stratégie (comme `DroneShipping`) ne nécessite aucun changement dans le contexte ou dans les autres stratégies.

---

Le **design pattern Strategy** est idéal pour remplacer les instructions conditionnelles complexes (comme les `if` ou `switch`) par un code modulaire et extensible.