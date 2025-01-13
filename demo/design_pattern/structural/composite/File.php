<?php


namespace structural\composite;
// La classe File représente un objet simple (feuille).
require_once "Component.php";

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