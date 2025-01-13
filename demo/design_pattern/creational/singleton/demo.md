### Exemple simple : Gestionnaire d'Identifiant Unique (Unique ID Generator)

Cet exemple implémente un Singleton pour générer des identifiants uniques. Cela garantit qu'une seule instance du générateur est utilisée, évitant tout conflit ou duplication d'identifiants.

---

### Classe Singleton

#### **UniqueIdGenerator.php**

```php
<?php

class UniqueIdGenerator
{
    private static ?UniqueIdGenerator $instance = null;
    private int $currentId;

    // Constructeur privé pour empêcher l'instantiation directe
    private function __construct()
    {
        $this->currentId = 0; // Initialise l'identifiant à 0
    }

    // Empêcher le clonage de l'instance
    private function __clone()
    {
    }

    // Empêcher la désérialisation
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    // Méthode pour récupérer l'instance unique
    public static function getInstance(): UniqueIdGenerator
    {
        if (self::$instance === null) {
            self::$instance = new UniqueIdGenerator();
        }
        return self::$instance;
    }

    // Méthode pour générer un identifiant unique
    public function generate(): int
    {
        return ++$this->currentId;
    }
}
```

---

### Script de démonstration

#### **Demo.php**

```php
<?php

require_once 'UniqueIdGenerator.php';

// Récupérer l'instance du singleton
$idGenerator1 = UniqueIdGenerator::getInstance();

// Générer quelques identifiants uniques
echo "First ID: " . $idGenerator1->generate() . "\n"; // Output: 1
echo "Second ID: " . $idGenerator1->generate() . "\n"; // Output: 2

// Récupérer une autre référence au singleton
$idGenerator2 = UniqueIdGenerator::getInstance();
echo "Third ID from another reference: " . $idGenerator2->generate() . "\n"; // Output: 3

// Vérifier si les deux références pointent vers la même instance
if ($idGenerator1 === $idGenerator2) {
    echo "Both references point to the same instance.\n"; // Output attendu
} else {
    echo "The references point to different instances.\n";
}
```

---

### Structure des fichiers

```
singleton_simple/
  UniqueIdGenerator.php
  Demo.php
```

---

### Exécution

1. Placez les fichiers dans le répertoire `singleton_simple`.
2. Exécutez le script `Demo.php` :
   ```bash
   php Demo.php
   ```

---

### Résultat attendu

```
First ID: 1
Second ID: 2
Third ID from another reference: 3
Both references point to the same instance.
```

---

### Explications

1. **Méthode `getInstance()`** :
   - Assure qu'une seule instance de `UniqueIdGenerator` est créée.

2. **Méthode `generate()`** :
   - Incrémente un compteur interne pour garantir que chaque identifiant est unique.

3. **Vérification des références** :
   - La comparaison avec `===` montre que toutes les références pointent vers le même objet.

---

### Simplicité

Cet exemple illustre un cas minimaliste et pratique du Singleton, adapté à tout scénario où un générateur d'identifiants unique est nécessaire.