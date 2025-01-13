<?php

class Person {
    // Attributs privés
    private $name;
    private $age;

    // Constructeur pour initialiser les attributs
    public function __construct($name, $age) {
        $this->setName($name); // Utilisation des méthodes getter/setter pour initialiser
        $this->setAge($age);
    }

    // Méthode getter pour obtenir le nom
    public function getName() {
        return $this->name;
    }

    // Méthode setter pour définir le nom
    public function setName($name) {
        if (!empty($name)) {
            $this->name = $name;
        } else {
            echo "Name cannot be empty.\n";
        }
    }

    // Méthode getter pour obtenir l'âge
    public function getAge() {
        return $this->age;
    }

    // Méthode setter pour définir l'âge
    public function setAge($age) {
        if ($age > 0) {
            $this->age = $age;
        } else {
            echo "Age must be a positive number.\n";
        }
    }

    // Méthode pour afficher les informations de la personne
    public function displayInfo() {
        echo "Name: " . $this->getName() . ", Age: " . $this->getAge() . "\n";
    }
}
