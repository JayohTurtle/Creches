<?php

require_once(__DIR__ . '/../config/mysql.php');
require_once(__DIR__ . '/../config/databaseconnect.php');

$getDepartements = $mysqlCreche->prepare("SELECT departement FROM departements");
$getDepartements->execute();

// Récupérer les résultats
$departements = $getDepartements->fetchAll(PDO::FETCH_ASSOC);

?>
