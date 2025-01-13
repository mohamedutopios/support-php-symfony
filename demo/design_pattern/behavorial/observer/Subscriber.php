<?php

require_once 'ObserverInterface.php';

class Subscriber implements ObserverInterface
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function update(string $message): void
    {
        echo "{$this->name} received notification: {$message}" . PHP_EOL;
    }
}