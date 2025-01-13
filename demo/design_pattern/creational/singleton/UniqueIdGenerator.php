<?php

namespace singleton;

class UniqueIdGenerator
{
    private static ?UniqueIdGenerator $instance = null;
    private int $currentId;

    // Constructeur privé pour empêcher l'instantiation directe
    private function __construct()
    {
        $this->currentId = 0; // Initialise l'identifiant à 0
    }

    // Empêcher le clonage de l'instance
    private function __clone()
    {
    }

    // Empêcher la désérialisation
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    // Méthode pour récupérer l'instance unique
    public static function getInstance(): UniqueIdGenerator
    {
        if (self::$instance === null) {
            self::$instance = new UniqueIdGenerator();
        }
        return self::$instance;
    }

    // Méthode pour générer un identifiant unique
    public function generate(): int
    {
        return ++$this->currentId;
    }
}
