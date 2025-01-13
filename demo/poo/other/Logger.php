<?php

namespace other;

trait Logger {
    public function log($message) {
        echo "Log: " . $message . "\n";
    }
}