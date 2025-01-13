<?php

require_once "User.php";
class UserBuilder
{
    private User $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function setFirstName(string $firstName): self
    {
        $this->user->firstName = $firstName;
        return $this;
    }

    public function setLastName(string $lastName): self
    {
        $this->user->lastName = $lastName;
        return $this;
    }

    public function setAge(int $age): self
    {
        $this->user->age = $age;
        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->user->email = $email;
        return $this;
    }

    public function setPhone(string $phone): self
    {
        $this->user->phone = $phone;
        return $this;
    }

    public function build(): User
    {
        return $this->user;
    }
}