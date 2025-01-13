<?php

require_once "Person.php";

$person = new Person("Alice", 30);
$person->displayInfo();  // Affiche les informations

// Tentative d'accès direct aux attributs (produira une erreur)
//echo $person->name;
