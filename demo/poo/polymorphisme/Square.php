<?php

namespace polymorphisme;

require_once "Square.php";

class Square extends Shape {
    public function draw() {
        echo "Drawing a square\n";
    }
}