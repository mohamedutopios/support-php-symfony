<?php


require_once 'Blog.php';
require_once 'Subscriber.php';

// Create the subject
$blog = new Blog();

// Create observers
$subscriber1 = new Subscriber("Alice");
$subscriber2 = new Subscriber("Bob");
$subscriber3 = new Subscriber("Charlie");

// Attach observers to the subject
$blog->attach($subscriber1);
$blog->attach($subscriber2);
$blog->attach($subscriber3);

// Publish a new blog post
$blog->publish("Observer Pattern in PHP");

// Detach one observer
$blog->detach($subscriber2);

// Publish another blog post
$blog->publish("Dependency Injection Explained");