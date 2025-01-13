Voici des démonstrations complètes et détaillées des **design patterns** Factory, Builder, Prototype, et Singleton en **PHP**.

---

## **1. Factory Pattern**
Le **Factory Pattern** permet de créer des objets sans spécifier la classe concrète à instancier.

### Exemple : Création de différents types de véhicules

```php
// Product Interface
interface VehicleInterface
{
    public function getType(): string;
}

// Concrete Products
class Car implements VehicleInterface
{
    public function getType(): string
    {
        return "Car";
    }
}

class Bike implements VehicleInterface
{
    public function getType(): string
    {
        return "Bike";
    }
}

// Factory
class VehicleFactory
{
    public static function create(string $type): VehicleInterface
    {
        return match ($type) {
            'car' => new Car(),
            'bike' => new Bike(),
            default => throw new Exception("Invalid vehicle type"),
        };
    }
}

// Usage
$car = VehicleFactory::create('car');
echo $car->getType(); // Output: Car

$bike = VehicleFactory::create('bike');
echo $bike->getType(); // Output: Bike
```

---

## **2. Builder Pattern**
Le **Builder Pattern** est utilisé pour construire des objets complexes étape par étape.

### Exemple : Construction d'un utilisateur avec des attributs facultatifs

```php
// Product
class User
{
    public string $firstName;
    public string $lastName;
    public int $age;
    public ?string $email;
    public ?string $phone;

    public function __toString(): string
    {
        return "Name: $this->firstName $this->lastName, Age: $this->age, Email: $this->email, Phone: $this->phone";
    }
}

// Builder
class UserBuilder
{
    private User $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function setFirstName(string $firstName): self
    {
        $this->user->firstName = $firstName;
        return $this;
    }

    public function setLastName(string $lastName): self
    {
        $this->user->lastName = $lastName;
        return $this;
    }

    public function setAge(int $age): self
    {
        $this->user->age = $age;
        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->user->email = $email;
        return $this;
    }

    public function setPhone(string $phone): self
    {
        $this->user->phone = $phone;
        return $this;
    }

    public function build(): User
    {
        return $this->user;
    }
}

// Usage
$builder = new UserBuilder();
$user = $builder
    ->setFirstName('John')
    ->setLastName('Doe')
    ->setAge(30)
    ->setEmail('john.doe@example.com')
    ->build();

echo $user;
// Output: Name: John Doe, Age: 30, Email: john.doe@example.com, Phone:
```

---

## **3. Prototype Pattern**
Le **Prototype Pattern** permet de cloner des objets existants sans passer par leur instantiation directe.

### Exemple : Clonage de véhicules

```php
// Prototype Interface
abstract class VehiclePrototype
{
    public string $type;
    public string $color;

    abstract public function __clone();
}

// Concrete Prototype
class CarPrototype extends VehiclePrototype
{
    public function __construct()
    {
        $this->type = "Car";
    }

    public function __clone()
    {
        // Actions spécifiques lors du clonage (si nécessaire)
    }
}

// Usage
$carPrototype = new CarPrototype();
$carPrototype->color = "Red";

$clonedCar = clone $carPrototype;
$clonedCar->color = "Blue";

echo "Original Car Color: " . $carPrototype->color . PHP_EOL; // Output: Red
echo "Cloned Car Color: " . $clonedCar->color . PHP_EOL;     // Output: Blue
```

---

## **4. Singleton Pattern**
Le **Singleton Pattern** garantit qu'une classe n'a qu'une seule instance et fournit un point d'accès global à celle-ci.

### Exemple : Gestionnaire de configuration

```php
class Config
{
    private static ?Config $instance = null;
    private array $settings = [];

    private function __construct()
    {
        // Constructeur privé pour empêcher l'instantiation directe
    }

    public static function getInstance(): Config
    {
        if (self::$instance === null) {
            self::$instance = new Config();
        }
        return self::$instance;
    }

    public function set(string $key, $value): void
    {
        $this->settings[$key] = $value;
    }

    public function get(string $key)
    {
        return $this->settings[$key] ?? null;
    }

    private function __clone()
    {
        // Empêcher le clonage
    }

    private function __wakeup()
    {
        // Empêcher la désérialisation
    }
}

// Usage
$config = Config::getInstance();
$config->set('database', 'MySQL');
echo $config->get('database'); // Output: MySQL

// Nouvelle tentative d'accès
$newConfig = Config::getInstance();
echo $newConfig->get('database'); // Output: MySQL
```

---

Ces exemples couvrent l'utilisation des **design patterns** en PHP avec des cas d'usage réalistes. Symfony peut également tirer parti de ces patterns dans la gestion de services et d'objets métier.