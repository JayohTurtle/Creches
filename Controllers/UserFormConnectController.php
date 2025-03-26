<?php

class UserFormConnectController{ 
    
    private $userManager;

    public function __construct() {
        $this->userManager = new UserManager();
    }

    public function showUserFormConnect() {
        $view = new View();
        $view->render("userFormConnect", []);
    }

    public function logout() {
        session_destroy();
        $view = new View();
        $view->render("userFormConnect",[]);
        exit;
    }

    public function userCreated(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $this->sanitizeInput($_POST['email']);
            $password = $this->sanitizeInput($_POST['password']);

            if ($this->userManager->createUser($email, $password)) {
                $_SESSION['success_message'] = "Utilisateur créé avec succès !"; // ✅ Message en session
            } else {
                $_SESSION['error_message'] = "Une erreur est survenue lors de la création de l'utilisateur.";
            }
    
            // Redirection pour afficher le message dans la vue
            header("Location: index.php?action=createUser");  
            exit();
    
        }
    }

    public function showCreateUser(){
        $view = new View();
        $view->render("createUser", []);
    }
    /**
     * Fonction utilitaire pour nettoyer les entrées utilisateur destinées à la base de données.
     */
    private function sanitizeInput($input) {
        if (is_array($input)) {
            return array_map([$this, 'sanitizeInput'], $input); // Nettoie les entrées dans les tableaux
        }
        return trim($input); // Supprime simplement les espaces inutiles
    }
}
