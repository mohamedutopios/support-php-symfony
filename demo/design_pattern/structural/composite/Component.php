<?php

namespace structural\composite;
// L'interface Component définit les méthodes communes.
interface Component {
    public function getName();
    public function display();
}