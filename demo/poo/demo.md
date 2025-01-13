Voici des démonstrations des concepts fondamentaux de la programmation orientée objet (POO) en PHP, tels que le **polymorphisme**, l'**encapsulation**, l'**héritage**, etc. Chaque démonstration met en lumière l'usage pratique de ces concepts.

### 1. **Encapsulation**

L'encapsulation consiste à regrouper les données et les méthodes qui manipulent ces données dans une même entité (classe) et à restreindre l'accès direct aux données en utilisant des modificateurs de visibilité (public, private, protected).

```php
<?php

class Car {
    // Attributs privés, donc accessibles uniquement à l'intérieur de la classe
    private $brand;
    private $model;

    // Constructeur pour initialiser les attributs
    public function __construct($brand, $model) {
        $this->brand = $brand;
        $this->model = $model;
    }

    // Méthodes publiques pour accéder aux attributs privés
    public function getBrand() {
        return $this->brand;
    }

    public function getModel() {
        return $this->model;
    }

    // Méthode pour afficher une description complète
    public function getCarDescription() {
        return "This is a {$this->brand} {$this->model}.";
    }
}

// Création d'un objet
$car = new Car("Toyota", "Corolla");
echo $car->getCarDescription();  // Accède à une méthode publique
// echo $car->brand;  // Erreur, l'attribut est privé
?>
```

### Explication :
- **Encapsulation** : Les attributs `$brand` et `$model` sont privés et ne peuvent pas être directement modifiés ou accédés de l'extérieur de la classe. Les méthodes publiques (`getBrand()`, `getModel()`) sont utilisées pour accéder à ces données de manière contrôlée.

### 2. **Héritage**

L'héritage permet à une classe enfant de hériter des propriétés et des méthodes d'une classe parent, ce qui permet de réutiliser du code et de spécialiser le comportement.

```php
<?php

// Classe parent
class Animal {
    public $name;

    public function __construct($name) {
        $this->name = $name;
    }

    public function speak() {
        echo "I am an animal.\n";
    }
}

// Classe enfant
class Dog extends Animal {
    public function speak() {
        echo "Woof! My name is {$this->name}.\n";
    }
}

// Création d'un objet de la classe enfant
$dog = new Dog("Buddy");
$dog->speak();  // Appelle la méthode redéfinie dans la classe Dog

?>
```

### Explication :
- **Héritage** : La classe `Dog` hérite de la classe `Animal` et redéfinit la méthode `speak()`. Cela permet à un objet `Dog` de se comporter de manière spécifique tout en bénéficiant des attributs et méthodes de la classe parent `Animal`.

### 3. **Polymorphisme**

Le polymorphisme permet d'utiliser une même méthode, mais avec des comportements différents selon le type d'objet qui l'appelle. Il peut être réalisé par héritage ou par interface.

#### Polymorphisme avec héritage :
```php
<?php

class Shape {
    public function draw() {
        echo "Drawing a shape\n";
    }
}

class Circle extends Shape {
    public function draw() {
        echo "Drawing a circle\n";
    }
}

class Square extends Shape {
    public function draw() {
        echo "Drawing a square\n";
    }
}

$shapes = [new Circle(), new Square()];

// Exemple de polymorphisme
foreach ($shapes as $shape) {
    $shape->draw();  // Appelle la méthode draw() appropriée selon le type de l'objet
}

?>
```

#### Polymorphisme avec interface :
```php
<?php

// Définition d'une interface
interface Animal {
    public function speak();
}

class Dog implements Animal {
    public function speak() {
        echo "Woof!\n";
    }
}

class Cat implements Animal {
    public function speak() {
        echo "Meow!\n";
    }
}

$animals = [new Dog(), new Cat()];

foreach ($animals as $animal) {
    $animal->speak();  // Polymorphisme : chaque classe implémente l'interface Animal à sa manière
}

?>
```

### Explication :
- **Polymorphisme** : Dans l'exemple avec les formes géométriques (`Shape`, `Circle`, `Square`), la méthode `draw()` est appelée de manière polymorphe, mais le comportement exact dépend de l'objet (cercle ou carré).
- Dans l'exemple avec l'interface `Animal`, chaque classe (`Dog`, `Cat`) implémente la méthode `speak()` de manière différente, illustrant le polymorphisme basé sur une interface.

### 4. **Abstraction**

L'abstraction permet de définir une interface ou une classe parent avec des méthodes non implémentées (méthodes abstraites) que les classes enfants doivent obligatoirement implémenter.

```php
<?php

// Classe abstraite
abstract class Animal {
    public $name;

    public function __construct($name) {
        $this->name = $name;
    }

    // Méthode abstraite (à implémenter dans les classes enfants)
    abstract public function speak();
}

class Dog extends Animal {
    public function speak() {
        echo "Woof! My name is {$this->name}.\n";
    }
}

$dog = new Dog("Buddy");
$dog->speak();  // Appel de la méthode implémentée dans la classe Dog

?>
```

### Explication :
- **Abstraction** : La classe `Animal` est abstraite et définit une méthode `speak()` que chaque sous-classe doit implémenter. Cela permet de définir un contrat que les classes enfants doivent respecter, tout en laissant une grande flexibilité dans l'implémentation.

### 5. **Constructeurs et Destructeurs**

Les constructeurs et destructeurs permettent d'initialiser un objet au moment de sa création et de libérer les ressources au moment de sa destruction.

```php
<?php

class Person {
    private $name;

    // Constructeur
    public function __construct($name) {
        $this->name = $name;
        echo "Person {$this->name} created.\n";
    }

    // Destructeur
    public function __destruct() {
        echo "Person {$this->name} destroyed.\n";
    }
}

// Création d'un objet
$person = new Person("John");
// L'objet sera automatiquement détruit à la fin du script ou de la portée
?>
```

### Explication :
- **Constructeur** : La méthode `__construct()` est appelée lors de la création d'un objet pour initialiser les propriétés.
- **Destructeur** : La méthode `__destruct()` est appelée lorsque l'objet est détruit, par exemple à la fin du script ou quand l'objet sort de sa portée.

### Conclusion :
Ces démonstrations illustrent des concepts clés de la **programmation orientée objet** en PHP :
- **Encapsulation** : Protection et gestion des données d'un objet.
- **Héritage** : Réutilisation et extension du code des classes parents.
- **Polymorphisme** : Utilisation de méthodes avec des comportements différents selon l'objet.
- **Abstraction** : Définition de structures de classes qui imposent un contrat d'implémentation.
- **Constructeurs et Destructeurs** : Initialisation et nettoyage des objets.

Ces concepts sont essentiels pour créer des applications modulaires, évolutives et maintenables.