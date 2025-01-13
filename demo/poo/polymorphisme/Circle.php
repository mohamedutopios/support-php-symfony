<?php

namespace polymorphisme;

require_once "Shape.php";

class Circle extends Shape {
    public function draw() {
        echo "Drawing a circle\n";
    }
}