### Introduction aux **Twig Components** et **Live Components** avec Symfony UX

Symfony UX propose des outils pour construire des interfaces utilisateur modernes, réactives et dynamiques tout en restant dans l'environnement PHP avec Twig. Les **Twig Components** et **Live Components** sont des éléments clés de cette approche, permettant respectivement de structurer et de dynamiser vos interfaces.

---

## **1. Twig Component**

Les **Twig Components** offrent un moyen structuré de créer des éléments réutilisables avec leur propre logique et template.

### Caractéristiques principales :
- **Modularité** : Les Twig Components encapsulent la logique et l'affichage dans des modules réutilisables.
- **Interopérabilité** : Ils fonctionnent exclusivement avec Twig, sans nécessiter de connaissances spécifiques en JavaScript.
- **Simplicité** : Parfait pour les interfaces statiques ou légèrement dynamiques.

---

### **Mise en place d’un Twig Component**

#### Installation :
Ajoutez le package requis pour utiliser Twig Component :
```bash
composer require symfony/ux-twig-component
```

#### Création d’un composant :
Utilisez la commande pour générer un composant :
```bash
php bin/console make:twig-component Alert
```

Cela génère deux fichiers :
1. **`src/Twig/Component/Alert.php`** (logique métier du composant).
2. **`templates/components/alert.html.twig`** (template associé).

#### Exemple de composant simple :

**Fichier PHP :**
```php
namespace App\Twig\Component;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('alert')]
class Alert
{
    public string $type = 'success'; // Type par défaut
    public string $message;         // Message à afficher
}
```

**Fichier Twig :**
```twig
<div class="alert alert-{{ type }}">
    {{ message }}
</div>
```

**Utilisation dans un autre template :**
```twig
{{ component('alert', { type: 'warning', message: 'Attention, Twig Components rocks!' }) }}
```

---

### **Syntaxe HTML enrichie avec `twig:`**

Avec Symfony 7+, vous pouvez utiliser une syntaxe proche de celle des frameworks front-end :
```html
<twig:alert type="info" message="This is a reusable component!" />
```

---

### **Slots dans Twig Components**

Les **slots** permettent d’inclure du contenu dynamique ou conditionnel dans un composant.

#### Exemple avec un slot :
**Template avec slot :**
```twig
<div class="alert alert-{{ type }}">
    {{ message }}
    {% if slot('extra') %}
        <div class="extra-content">
            {{ slot('extra') }}
        </div>
    {% endif %}
</div>
```

**Utilisation :**
```twig
<twig:alert type="info" message="Here's the message">
    <slot name="extra">
        <p>Contenu additionnel avec un lien : <a href="#">cliquez ici</a></p>
    </slot>
</twig:alert>
```

---

## **2. Live Component**

Les **Live Components** enrichissent les Twig Components en leur ajoutant des capacités interactives et dynamiques via AJAX, sans recharger la page. Ils permettent de construire des interfaces réactives en restant dans un environnement Symfony et PHP.

### Caractéristiques principales :
- **Réactivité** : Dynamisez les interfaces utilisateur avec des mises à jour côté serveur sans rafraîchissement de page.
- **Interopérabilité JavaScript** : Basé sur Stimulus et Turbo Streams, mais sans écrire de JS complexe.
- **Automatisation** : Synchronisation automatique entre l'état côté serveur et l'interface utilisateur.

---

### **Mise en place d’un Live Component**

#### Installation :
Ajoutez les packages nécessaires :
```bash
composer require symfony/ux-live-component
yarn add @symfony/ux-live-component
yarn dev
```

#### Création d’un composant :
```bash
php bin/console make:live-component Counter
```

Cela génère deux fichiers :
1. **`src/Twig/Component/Counter.php`** : Classe PHP du composant.
2. **`templates/components/counter.html.twig`** : Template Twig associé.

---

### Exemple de Live Component simple :

**Classe PHP :**
```php
namespace App\Twig\Component;

use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent('counter')]
class Counter
{
    use DefaultActionTrait;

    #[LiveProp]
    public int $count = 0;

    public function increment(): void
    {
        $this->count++;
    }
}
```

**Template Twig :**
```twig
<div>
    <p>Compteur : {{ count }}</p>
    <button wire:click="increment">Incrémenter</button>
</div>
```

**Utilisation dans un template :**
```twig
{{ component('counter') }}
```

Dans cet exemple :
- `#[LiveProp]` permet de synchroniser la variable `$count` entre le front-end et le serveur.
- `wire:click="increment"` déclenche l'exécution de la méthode `increment()` côté serveur.

---

### **Fonctionnalités avancées avec Live Components**

#### **1. Props synchronisées avec des formulaires**
Les Live Props peuvent être liées à des champs de formulaire pour des mises à jour en temps réel.

**Classe PHP :**
```php
#[LiveProp]
public string $name = '';
```

**Template Twig :**
```twig
<input type="text" wire:model="name" />
<p>Bonjour, {{ name }} !</p>
```

---

#### **2. Gestion des événements**

Vous pouvez écouter ou déclencher des événements depuis un Live Component.

**Classe PHP :**
```php
public function resetCount(): void
{
    $this->count = 0;
}
```

**Template Twig :**
```twig
<button wire:click="resetCount">Réinitialiser</button>
```

---

#### **3. Intégration avec Stimulus**
Live Component peut s'intégrer avec Stimulus pour gérer des interactions plus complexes.

---

## **Twig Components vs Live Components**

| **Aspect**               | **Twig Component**                                | **Live Component**                               |
|--------------------------|--------------------------------------------------|------------------------------------------------|
| **Usage principal**      | Composants statiques ou légèrement dynamiques    | Interfaces interactives et réactives           |
| **Interopérabilité JS**  | Pas nécessaire                                   | Nécessite Stimulus et Turbo                    |
| **Rafraîchissement DOM** | Complet                                          | Partiel grâce à Turbo Streams                  |
| **Synchronisation**      | Non (données passées uniquement en paramètres)   | Oui, entre le front-end et le serveur          |
| **Installation**         | Simplicité                                       | Plus complexe                                  |

---

## **Bonnes pratiques**

### Twig Components :
- Utilisez-les pour les éléments d'interface statiques ou faiblement dynamiques comme les boutons, cartes ou messages d'alerte.
- Encapsulez des morceaux réutilisables d'interface utilisateur.

### Live Components :
- Adaptez-les aux interfaces interactives nécessitant une mise à jour dynamique, comme :
  - Les filtres dynamiques sur des tableaux.
  - Les formulaires avec validation en temps réel.
  - Les compteurs ou graphiques mis à jour dynamiquement.
- Ne surchargez pas la classe PHP avec de la logique métier complexe. Placez-la dans des services dédiés.

---

Si vous souhaitez des exemples spécifiques ou des cas pratiques, je peux vous fournir du code et des explications détaillées adaptés à votre projet.