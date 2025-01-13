<?php

namespace polymorphisme;

require_once "Circle.php";
require_once "Square.php";

$shapes = [new Circle(), new Square()];

// Exemple de polymorphisme
foreach ($shapes as $shape) {
    $shape->draw();  // Appelle la méthode draw() appropriée selon le type de l'objet
}