<?php

require_once "UserBuilder.php";

$builder = new UserBuilder();
$builder1 = new UserBuilder();
$user = $builder
    ->setFirstName('John')
    ->setLastName('Doe')
    ->setAge(30)
    ->setEmail('john.doe@example.com')
    ->build();

$user1 = $builder1
    ->setLastName('Tom')
    ->setEmail('tom.doe@example.com')
    ->build();

echo $user;
echo "\n";
echo $user1;
