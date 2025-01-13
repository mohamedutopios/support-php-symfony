<?php

namespace structural\composite;
// La classe File représente un objet simple (feuille).
require_once "Component.php";

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