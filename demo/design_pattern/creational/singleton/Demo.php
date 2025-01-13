<?php

use singleton\UniqueIdGenerator;

require_once 'UniqueIdGenerator.php';

// Récupérer l'instance du singleton
$idGenerator1 = UniqueIdGenerator::getInstance();

// Générer quelques identifiants uniques
echo "First ID: " . $idGenerator1->generate() . "\n"; // Output: 1
echo "Second ID: " . $idGenerator1->generate() . "\n"; // Output: 2

// Récupérer une autre référence au singleton
$idGenerator2 = UniqueIdGenerator::getInstance();
echo "Third ID from another reference: " . $idGenerator2->generate() . "\n"; // Output: 3

// Vérifier si les deux références pointent vers la même instance
if ($idGenerator1 === $idGenerator2) {
    echo "Both references point to the same instance.\n"; // Output attendu
} else {
    echo "The references point to different instances.\n";
}
