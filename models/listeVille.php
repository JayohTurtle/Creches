<?php

require_once(__DIR__ . '/../config/mysql.php');
require_once(__DIR__ . '/../config/databaseconnect.php');



$getVilles = $mysqlCreche->prepare("SELECT ville FROM villes");
$getVilles->execute();

// Récupérer les résultats
$villes = $getVilles->fetchAll(PDO::FETCH_ASSOC);

?>
