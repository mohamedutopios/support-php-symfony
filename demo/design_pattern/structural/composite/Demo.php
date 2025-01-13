<?php

namespace structural\composite;
require_once "File.php";
require_once "Folder.php";
require_once "Component.php";

// Exemple d'utilisation du pattern Composite
$rootFolder = new Folder("Root");
$file1 = new File("File1.txt");
$file2 = new File("File2.txt");

$subFolder = new Folder("SubFolder");
$file3 = new File("File3.txt");

$rootFolder->add($file1);
$rootFolder->add($file2);
$rootFolder->add($subFolder);

$subFolder->add($file3);

// Affichage récursif de la structure
$rootFolder->display();
