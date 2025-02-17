<?php

class ChangePasswordController {

    private $userManager;

    public function __construct() {
        $this->userManager = new UserManager();
    }

    public function changePassword() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $newPassword = $_POST['newPassword'];
            $confirmPassword = $_POST['confirmPassword'];

            if ($newPassword !== $confirmPassword) {
                echo "Les mots de passe ne correspondent pas.";
                return;
            }

            $userId = $_SESSION['user_id'];
        
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
}
?>
