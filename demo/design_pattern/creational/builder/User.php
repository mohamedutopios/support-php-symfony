<?php
class User
{
    public string $firstName = 'Unknown';
    public string $lastName = 'Unknown';
    public int $age = 0; // Non nullable avec une valeur par défaut
    public ?string $email = null;
    public ?string $phone = null;

    public function __toString(): string
    {
        return "Name: " .
            $this->firstName . " " .
            $this->lastName .
            ", Age: " .
            $this->age . // Pas besoin de vérifier
            ", Email: " .
            ($this->email ?? 'N/A') .
            ", Phone: " .
            ($this->phone ?? 'N/A');
    }
}

