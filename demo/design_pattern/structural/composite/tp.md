Voici un autre exemple pour le **design pattern Composite** en PHP, où nous allons simuler une structure hiérarchique d'éléments dans un **menu de navigation**. Dans cet exemple, un menu peut être soit un **élément de menu individuel**, soit un **sous-menu** composé de plusieurs éléments de menu.

### Code PHP :

```php
<?php

// L'interface Component définit les méthodes communes pour les éléments du menu
interface MenuComponent {
    public function getName();
    public function display();
}

// La classe MenuItem représente un élément simple du menu (feuille)
class MenuItem implements MenuComponent {
    private $name;
    
    public function __construct($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function display() {
        echo "Menu Item: " . $this->name . "\n";
    }
}

// La classe Menu représente un menu composite (dossier) pouvant contenir des éléments ou d'autres menus
class Menu implements MenuComponent {
    private $name;
    private $children = [];

    public function __construct($name) {
        $this->name = $name;
    }

    // Ajoute un composant (élément de menu ou sous-menu)
    public function add(MenuComponent $component) {
        $this->children[] = $component;
    }

    // Affiche tous les composants du menu (récursivement)
    public function display() {
        echo "Menu: " . $this->name . "\n";
        foreach ($this->children as $child) {
            $child->display();
        }
    }

    public function getName() {
        return $this->name;
    }
}

// Exemple d'utilisation du pattern Composite
$mainMenu = new Menu("Main Menu");
$homeItem = new MenuItem("Home");
$aboutItem = new MenuItem("About");

$servicesMenu = new Menu("Services");
$webDevItem = new MenuItem("Web Development");
$seoItem = new MenuItem("SEO");

$contactItem = new MenuItem("Contact");

// Construction du menu
$servicesMenu->add($webDevItem);
$servicesMenu->add($seoItem);

$mainMenu->add($homeItem);
$mainMenu->add($aboutItem);
$mainMenu->add($servicesMenu);
$mainMenu->add($contactItem);

// Affichage récursif de la structure du menu
$mainMenu->display();

?>
```

### Explication :

1. **Interface `MenuComponent`** : Cette interface définit les méthodes communes à tous les éléments du menu, que ce soit des éléments individuels (MenuItem) ou des menus composés (Menu). Elle possède deux méthodes : `getName()` pour obtenir le nom de l'élément et `display()` pour afficher l'élément.

2. **Classe `MenuItem`** : Cette classe représente un élément individuel du menu, comme un lien vers une page. Elle implémente l'interface `MenuComponent` et affiche simplement son nom lorsqu'elle est demandée.

3. **Classe `Menu`** : Cette classe représente un menu composite, pouvant contenir plusieurs éléments de menu ou d'autres sous-menus. Elle implémente aussi `MenuComponent`. Le menu peut ajouter des éléments avec la méthode `add()`, et la méthode `display()` parcourt tous ses enfants (éléments ou sous-menus) pour les afficher récursivement.

### Sortie attendue :

```
Menu: Main Menu
Menu Item: Home
Menu Item: About
Menu: Services
Menu Item: Web Development
Menu Item: SEO
Menu Item: Contact
```

### Conclusion :

Ce modèle permet de gérer des éléments individuels (comme des items de menu) et des structures composites (comme des menus contenant d'autres éléments ou sous-menus) de manière uniforme. Le design pattern Composite est très utile pour organiser des éléments en hiérarchies complexes tout en maintenant une interface simple et cohérente.