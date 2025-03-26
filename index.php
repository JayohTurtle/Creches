<?php

include_once('config.php');
include_once('view.php');
require_once __DIR__ . '/vendor/autoload.php';  // Charge Composer et PHPMailer

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Auto-chargement des modèles et contrôleurs (évite les include à rallonge)
spl_autoload_register(function ($class) {
    if (file_exists("Models/$class.php")) {
        include_once "Models/$class.php";
    } elseif (file_exists("Controllers/$class.php")) {
        include_once "Controllers/$class.php";
    }
});

session_start();

$publicPages = ['userFormConnect', 'resetPassword', 'changePassword', 'forgotPassword', 'login', 'sendResetLink']; // Liste des pages accessibles sans connexion

$action = $_GET['action'] ?? 'home';

//Vérifier si l'utilisateur est connecté sauf pour les pages publiques
if (!isset($_SESSION['user']) && (!isset($_GET['action']) || !in_array($_GET['action'], $publicPages))) {
    header("Location: index.php?action=userFormConnect");
    exit;
}

// Récupération de l'action (par défaut : "accueil")
$action = $_REQUEST['action'] ?? 'accueil';

// Définition du contrôleur en fonction de l'action demandée
$controller = null;

switch ($action) {

    case 'userFormConnect':
        $controller = new UserFormConnectController();
        $controller->showUserFormConnect();
        break;

    case 'newContact':
        $controller = new NewContactController();
        $controller->showNewContact();
        break;

    case 'ajoutContact':
        $controller = new AjoutContactController();
        $controller->handleAjoutContact();
        break;

    case 'ajoutAcheteur':
        $controller = new AjoutAcheteurController();
        $controller->handleAjoutAcheteur();
        break;
    
    case 'ajoutVendeur':
        $controller = new AjoutVendeurController();
        $controller->handleAjoutVendeur();
        break;

    case 'contacts':
        $controller = new ContactsController();
        $controller->showContacts();
        break;
    
    case 'acheteurs':
        $controller = new AcheteursController();
        $controller->showAcheteurs();
        break;
    
    case 'vendeurs':
       $controller = new VendeursController();
       $controller->showVendeurs();
       break; 
       
    case 'seeStatuts':
        $controller = new StatutController();
        $controller->showStatut();
        break;
    
    case 'researchAcheteurs':
        $controller = new ResearchAcheteursController();
        $controller->handleResearchAcheteurs();
        break;
    
    case 'seeNiveaux':
        $controller = new NiveauController();
        $controller->showNiveau();
        break;

    case 'seeContact':
        $controller = new SeeContactController();
        $controller->selectSens();
        break; 

    case 'actionContact':
        $controller = new ActionContactController();
        $controller->handleActionContact();
        break; 
    
    case 'researchVendeurs':
        $controller = new ResearchVendeursController();
        $controller->handleResearchVendeurs();
        break;

    case 'login':
        $controller = new ConnectController();
        $controller->login();
        break;

    case 'logout':
        $controller = new ConnectController();
        $controller->logout();
        break;        

    case 'accueil':
        $controller = new AccueilController();
        $controller->showAccueil();
        break;

    case 'resultContacts':
        $controller = new ResultContactsController();
        $controller->showResultContacts();
        break;

    case 'researchContacts':
        $controller = new ResearchContactsController();
        $controller->handleResearchContacts();
        break;
    
    case 'resultZoneAchat':
        $controller = new resultZoneAchatController();
        $controller->showResultZoneAchat();
        break;

    case 'resultZoneVente':
        $controller = new ResultZoneVenteController();
        $controller->showResultZoneVente();
        break;
    
    case 'resultZoneContact':
        $controller = new ResultZoneContactController();
        $controller->showResultZoneContact();
        break;

    case 'creche':
        $controller = new CrecheController();
        $controller->showCreche();
        break;

    case 'ajoutNewLocalisation':
        $controller = new AjoutNewLocalisationController();
        $controller->handleAjoutNewLocalisation();
        break;

    case 'ajoutInfoContact':
        $controller = new AjoutInfoContactController();
        $controller->handleAjoutInfoContact();
        break;
    
    case 'confirmerModificationContact':
        $controller = new AjoutInfoContactController();
        $controller->handleConfirmationModificationContact();
        break;
    
    case 'modifInteretTaille':
        $controller = new ModifInteretTailleController();
        $controller->handleModifInteretTaille();
        break;
    
    case 'confirmerModifInteretTaille':
        $controller = new ModifInteretTailleController();
        $controller->handleConfirmationModificationInteretTaille();
        break;
    
    case 'ajoutInteretCreche':
        $controller = new AjoutInteretCrecheController();
        $controller->handleAjoutInteretCreche();
        break;

    case 'ajoutInteretVille':
        $controller = new AjoutInteretVilleController();
        $controller->handleAjoutInteretVille();
        break;

    case 'ajoutInteretDepartement':
        $controller = new AjoutInteretDepartementController();
        $controller->handleAjoutInteretDepartement();
        break;

    case 'ajoutInteretRegion':
        $controller = new AjoutInteretRegionController();
        $controller->handleAjoutInteretRegion();
        break;

    case 'ajoutInteretFrance':
        $controller = new AjoutInteretFranceController();
        $controller->handleAjoutInteretFrance();
        break;

    case 'ajoutNewLocalisation':
        $controller = new AjoutNewLocalisationController();
        $controller->handleAjoutNewLocalisation();
        break;

    case 'ajoutNewComment':
        $controller = new AjoutNewCommentController();
        $controller->handleAjoutNewComment();
        break;

    case 'modifCommission':
        $controller = new ModifCommissionController();
        $controller->handleModifCommission();
        break;

    case 'modifValorisation':
        $controller = new ModifValorisationController();
        $controller->handleModifValorisation();
        break;

    case 'confirmerModificationContact':
        $controller = new AjoutInfoContactController();
        $controller->handleConfirmationModificationContact();
        break;
}
