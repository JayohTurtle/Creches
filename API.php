<?php
header("Content-Type: application/json");
require_once "config.php"; 
require "Models/LocalisationManager.php";

$manager = new LocalisationManager();
$points = $manager->getPoints();

echo json_encode($points);
?>
