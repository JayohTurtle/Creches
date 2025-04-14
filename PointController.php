<?php
require_once 'Models/PointManager.php';
include_once ('config.php');


// Créer une instance du gestionnaire des points
$manager = new PointManager();

// Exécuter la mise à jour des localisations
$manager->updateAllCitiesLocations();

echo "Mise à jour des localisations terminée.";
?>