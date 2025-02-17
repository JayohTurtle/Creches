<?php
include_once 'Models/UserManager.php';
include_once 'config.php';

$userManager = new UserManager();
$userManager->createUser("jzabiolle@youinvest.fr", "Temp1234", "admin");

echo "Utilisateur ajouté avec succès.";
?>
