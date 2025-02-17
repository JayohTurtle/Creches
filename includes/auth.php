<?php

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header("Location: index.php?action=userFormConnect");
    exit;
}
?>
