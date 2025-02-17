<?php
include_once 'Models/UserManager.php';
include_once 'config.php';

$userManager = new UserManager();
$userManager->createUser("tdelabouvrie.fr", "Temp1234", "user");

echo "Utilisateur ajouté avec succès.";
?>
