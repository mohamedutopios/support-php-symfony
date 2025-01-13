### **Observer Pattern : Démonstration et Explication**

Le **Observer Pattern** est un **design pattern comportemental** qui définit une relation entre un objet "sujet" (ou observable) et plusieurs "observateurs". Quand le sujet change d'état, tous les observateurs sont automatiquement notifiés et mis à jour.

---

### **Concept**
- **Sujet (Observable)** : Maintient une liste d'observateurs et informe ces derniers des changements d'état.
- **Observateurs** : S'inscrivent auprès du sujet pour recevoir des notifications.

---

### **Cas d'usage**
Supposons un système de notifications pour une plateforme de blog. Lorsqu'un nouvel article est publié, les abonnés (observateurs) reçoivent une notification.

---

### **Implémentation en PHP**

#### **Étape 1 : Interface de l'Observateur**

```php
// Observer Interface
interface ObserverInterface
{
    public function update(string $message): void;
}
```

---

#### **Étape 2 : Interface du Sujet**

```php
// Subject Interface
interface SubjectInterface
{
    public function attach(ObserverInterface $observer): void;
    public function detach(ObserverInterface $observer): void;
    public function notify(): void;
}
```

---

#### **Étape 3 : Sujet Concret (Blog)**

```php
class Blog implements SubjectInterface
{
    private array $observers = [];
    private string $latestPost;

    public function attach(ObserverInterface $observer): void
    {
        $this->observers[] = $observer;
    }

    public function detach(ObserverInterface $observer): void
    {
        $this->observers = array_filter($this->observers, fn($obs) => $obs !== $observer);
    }

    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update("New blog post: {$this->latestPost}");
        }
    }

    public function publish(string $postTitle): void
    {
        $this->latestPost = $postTitle;
        $this->notify();
    }
}
```

---

#### **Étape 4 : Observateurs Concrets (Abonnés)**

```php
class Subscriber implements ObserverInterface
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function update(string $message): void
    {
        echo "{$this->name} received notification: {$message}" . PHP_EOL;
    }
}
```

---

#### **Étape 5 : Utilisation**

```php
// Create the subject
$blog = new Blog();

// Create observers
$subscriber1 = new Subscriber("Alice");
$subscriber2 = new Subscriber("Bob");
$subscriber3 = new Subscriber("Charlie");

// Attach observers to the subject
$blog->attach($subscriber1);
$blog->attach($subscriber2);
$blog->attach($subscriber3);

// Publish a new blog post
$blog->publish("Observer Pattern in PHP");

// Detach one observer
$blog->detach($subscriber2);

// Publish another blog post
$blog->publish("Dependency Injection Explained");
```

---

### **Résultat**
Lorsque le premier article est publié :
```
Alice received notification: New blog post: Observer Pattern in PHP
Bob received notification: New blog post: Observer Pattern in PHP
Charlie received notification: New blog post: Observer Pattern in PHP
```

Lorsque le deuxième article est publié (après que Bob soit détaché) :
```
Alice received notification: New blog post: Dependency Injection Explained
Charlie received notification: New blog post: Dependency Injection Explained
```

---

### **Explication**

1. **Attachement des observateurs** :
   Les abonnés s'inscrivent auprès du blog pour être notifiés de nouveaux articles.

2. **Notification des observateurs** :
   Lorsqu'un article est publié, le blog parcourt sa liste d'observateurs et appelle leur méthode `update`.

3. **Détachement des observateurs** :
   Bob se désinscrit, il ne reçoit donc plus de notifications.

---

### **Avantages**
- **Découplage** : Le sujet et les observateurs sont faiblement couplés, facilitant l'ajout de nouveaux observateurs ou la modification de leurs comportements.
- **Réutilisabilité** : Les observateurs peuvent être réutilisés avec différents sujets.

---

### **Inconvénients**
- **Complexité** : Augmente la complexité lorsqu'il y a un grand nombre d'observateurs ou de sujets.
- **Performance** : La notification de nombreux observateurs peut être coûteuse en termes de performances.

---

Cette implémentation montre comment utiliser le **Observer Pattern** pour gérer des relations dynamiques entre objets en PHP, avec un exemple concret et facile à adapter à d'autres cas d'usage.