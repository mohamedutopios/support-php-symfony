<?php

interface ObserverInterface
{
    public function update(string $message): void;
}