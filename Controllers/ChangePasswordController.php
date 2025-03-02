<?php

class ChangePasswordController {

    private $userManager;

    public function __construct() {
        $this->userManager = new UserManager();
    }

    public function changePassword() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $newPassword = $this->sanitizeInput($_POST['newPassword']);
            $confirmPassword = $this->sanitizeInput($_POST['confirmPassword']);

            if ($newPassword !== $confirmPassword) {
                echo "Les mots de passe ne correspondent pas.";
                return;
            }

            $userId = $_SESSION['userId'];
        
            $this->userManager->updatePassword($userId, $newPassword);

            // Stocker le message de succès en session
            $_SESSION['success_message'] = "Mot de passe modifié avec succès !";

            // Rediriger vers la page de connexion
            header("Location: index.php?action=userFormConnect");
            exit();
            }
    }
    
    public function showChangePasswordForm() {
        $view = new View();
        $view->render("changePassword", []);
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

