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

    case 'createUser':
        $controller = new ConnectController();
        $controller->showCreateUser();
        break;

    case 'userCreated':
        $controller = new ConnectController();
        $controller->userCreated();
        break;

    case 'userFormConnect':
        $controller = new ConnectController();
        $controller->showUserFormconnect();
        break;

    case 'login':
        $controller = new ConnectController();
        $controller->login();
        break;
    
    case 'logout':
        $controller = new ConnectController();
        $controller->logout();
        break;        
        
    case 'forgotPassword':
        $controller = new ResetPasswordController();
        $controller->showForgotPasswordForm();
        break;

    case 'changePassword':
        $controller = new ChangePasswordController();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $controller->changePassword();
        } else {
            $controller->showChangePasswordForm();
        }
        break;

    case 'accueil':
        $controller = new AccueilController();
        $controller->showAccueil();
        break;

    case 'clients':
        $controller = new ClientsController();
        $controller->showclients();
        break;

    case 'resultClient':
        $controller = new ResultClientController();
        $controller->handleResearchClient();
        break;

    case 'researchResultClient':
        $controller = new ResultClientController();
        $controller->handleResearchClient();
        break;

    case 'acheteurs':
        $controller = new AcheteursController();
        $controller->showAcheteurs();
        break;

    case 'resultAcheteur':
        $controller = new ResultAcheteursController();
        $controller->handleResearchAcheteur();
        break;

    case 'newContactForm':
        $controller = new ContactFormController();
        $controller->showContactForm();
        break;

    case 'saveContact':
        $controller = new AjoutContactController();
        $controller->handleAddContact();
        break;

    case 'seeContact':
        $controller = new ContactController();
        $controller->selectSens();

    case 'resultContacts':
        $controller = new ContactsController();
        $controller->showContacts();
        break;

    case 'researchResultContacts':
        $controller = new ResultContactsController();
        $controller->handleResearchContacts();
        break;
    
    case 'ajoutInfoContact':
        $controller = new AjoutInfoContactController();
        $controller->handleInfoContact();
        break;

    case 'ajoutComment':
        $controller = new AddCommentController();
        $controller->handleAddComment();
        break;

    case 'creche':
        $controller = new CrecheController();
        $controller->handleCreche();
    
    case 'ajoutInteretCreche':
        $controller = new AddInteretCrecheController();
        $controller->handleAddInteretCreche();
        break;
    
    case 'ajoutInteretGeneral':
        $controller = new AddInteretGeneralController();
        $controller->handleAddInteretGeneral();
        break;

    case 'ajoutNewLocalisation':
        $controller = new AddLocalisationController();
        $controller->handleAddLocalisation();
        break;

    case 'sendResetLink':
        $controller = new ResetPasswordController();
        $controller->sendResetLink();
        break;
    
    case 'resultZoneVente':
        $controller = new ResultZoneVenteController();
        $controller->showResultZoneVente();
        break;

    case 'resultZoneAchat':
        $controller = new resultZoneAchatController();
        $controller->showResultZoneAchat();
        break;

    case 'resultTaille':
        $controller = new ResultTailleController();
        $controller->showResultTaille();
        break;

    case 'interetsCreche':
        $controller = new InteretCrecheController();
        $controller->showInteretCreche();
        break;

    case 'resultInteretCreche':
        $controller = new ResultInteretCrecheController();
        $controller->showResultInteretCreche();
        break;

    case 'resultInteretGroupe':
        $controller = new ResultInteretGroupeController();
        $controller->showResultInteretGroupe();
        break;

    default:
        echo "La page '$action' n'existe pas.";
        break;

}
