Le design pattern **Composite** est un modèle structurel qui permet de traiter des objets individuels et des compositions d'objets de manière uniforme. Il est très utile lorsque vous avez une hiérarchie d'objets, comme un arbre, et que vous souhaitez traiter à la fois les objets simples (feuilles) et les objets composés (branches) de la même manière.

Voici une démonstration simple du design pattern Composite en PHP. Imaginons que nous ayons une structure représentant un **dossier** qui peut contenir à la fois des **fichiers** individuels et d'autres **dossiers**.

### Étapes :
1. **Définir une interface** commune pour les objets "composants" (fichiers et dossiers).
2. **Créer une classe pour les objets simples** (Fichier).
3. **Créer une classe pour les objets composés** (Dossier) qui peut contenir des objets simples ou d'autres objets composés.
4. **Utiliser l'interface** pour gérer de manière uniforme l'interaction avec les objets.

### Code PHP :

```php
<?php

// L'interface Component définit les méthodes communes.
interface Component {
    public function getName();
    public function display();
}

// La classe File représente un objet simple (feuille).
class File implements Component {
    private $name;
    
    public function __construct($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function display() {
        echo "File: " . $this->name . "\n";
    }
}

// La classe Folder représente un objet composite (dossier) pouvant contenir des objets simples ou d'autres dossiers.
class Folder implements Component {
    private $name;
    private $children = [];

    public function __construct($name) {
        $this->name = $name;
    }

    // Ajoute un composant (fichier ou dossier) dans le dossier
    public function add(Component $component) {
        $this->children[] = $component;
    }

    // Affiche tous les composants du dossier (récursivement)
    public function display() {
        echo "Folder: " . $this->name . "\n";
        foreach ($this->children as $child) {
            $child->display();
        }
    }

    public function getName() {
        return $this->name;
    }
}

// Exemple d'utilisation du pattern Composite
$rootFolder = new Folder("Root");
$file1 = new File("File1.txt");
$file2 = new File("File2.txt");

$subFolder = new Folder("SubFolder");
$file3 = new File("File3.txt");

$rootFolder->add($file1);
$rootFolder->add($file2);
$rootFolder->add($subFolder);

$subFolder->add($file3);

// Affichage récursif de la structure
$rootFolder->display();

?>
```

### Explication :

1. **Interface `Component`** : C'est l'interface commune pour tous les objets (fichiers et dossiers). Elle définit deux méthodes : `getName()` pour obtenir le nom de l'élément et `display()` pour afficher l'élément.

2. **Classe `File`** : Cette classe représente un fichier. Elle implémente l'interface `Component`, et ses méthodes affichent simplement le nom du fichier.

3. **Classe `Folder`** : Cette classe représente un dossier. Elle implémente également l'interface `Component`. Un dossier peut contenir plusieurs éléments (fichiers ou autres dossiers), gérés dans un tableau `$children`. La méthode `add()` permet d'ajouter des composants à ce tableau, et la méthode `display()` affiche récursivement le nom du dossier et de ses contenus.

### Sortie attendue :

```
Folder: Root
File: File1.txt
File: File2.txt
Folder: SubFolder
File: File3.txt
```

### Conclusion :

Ce modèle permet de traiter à la fois des objets simples (comme `File`) et des objets composites (comme `Folder`) de la même manière. Le design pattern Composite est particulièrement utile pour représenter des structures hiérarchiques, comme des systèmes de fichiers ou des arbres de décision, de manière élégante et extensible.