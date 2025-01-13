<?php

require_once 'SubjectInterface.php';
require_once 'ObserverInterface.php';

interface SubjectInterface
{
    public function attach(ObserverInterface $observer): void;
    public function detach(ObserverInterface $observer): void;
    public function notify(): void;
}