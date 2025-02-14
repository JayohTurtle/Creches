<?php

include_once('config.php');
include_once('view.php');


// Auto-chargement des modèles et contrôleurs (évite les include à rallonge)
spl_autoload_register(function ($class) {
    if (file_exists("Models/$class.php")) {
        include_once "Models/$class.php";
    } elseif (file_exists("Controllers/$class.php")) {
        include_once "Controllers/$class.php";
    }
});

// Récupération de l'action (par défaut : "dashboard")
$action = $_REQUEST['action'] ?? 'dashboard';

// Définition du contrôleur en fonction de l'action demandée
$controller = null;

switch ($action) {
    case 'dashboard':
        $controller = new DashboardController();
        $controller->showDashboard();
        break;

    case 'newContactForm':
        $controller = new ContactFormController();
        $controller->showContactForm();
        break;

    case 'saveContact': // Ajout d'une action pour enregistrer un contact
        $controller = new AddContactController();
        $controller->handleAddContact();
        break;

    case 'research':
        $controller = new ResearchController();
        $controller->showResearch();
        break;

    case 'researchResultContact':
        $controller = new ResearchResultContactController();
        $controller->showResultContact();
        break;

    case 'researchResultClient':
        $controller = new ResearchResultClientController();
        $controller->showResultClient();
        break;

    case 'researchResultTaille':
        $controller = new ResearchResultTailleController();
        $controller->showResultTaille();
        break;

    default:
        echo "La page '$action' n'existe pas.";
        break;
}
