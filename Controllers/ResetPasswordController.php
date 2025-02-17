<?php

class ResetPasswordController {
    public $db;

    public function __construct() {
        $this->db = DBManager::getInstance();
    }

    /**
     * Affiche le formulaire pour entrer l'email et demander une réinitialisation
     */
    public function showForgotPasswordForm() {
        $view = new View();
        $view->render("forgotPassword", []);
    }

    /**
     * Gère l'envoi du lien de réinitialisation par email
     */
    public function sendResetLink() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = trim($_POST['email']);
            $stmt = $this->db->query("SELECT idUser FROM users WHERE email = ?", [$email]);
            $user = $stmt->fetch();

            if ($user) {
                // Génération d'un token sécurisé
                $token = bin2hex(random_bytes(32));
                $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

                // Enregistrer le token dans la base de données
                $this->db->query("UPDATE users SET resetToken = ?, resetTokenExpiry = ? WHERE idUser = ?", [$token, $expiry, $user['idUser']]);

                // Lien de réinitialisation
                $resetLink = "http://localhost/creches/index.php?action=resetPassword&token=$token";

                // Envoi de l'email
                mail($email, "Réinitialisation de votre mot de passe", "Cliquez sur ce lien : $resetLink");

                echo "Un email de réinitialisation a été envoyé.";
            } else {
                echo "Aucun compte trouvé avec cet email.";
            }
        }
    }

    /**
     * Affiche le formulaire de réinitialisation de mot de passe
     */
    public function showResetPasswordForm() {
        $view = new View();
        $view->render("resetPassword", ["token" => $_GET['token'] ?? '']);
    }

    /**
     * Gère la mise à jour du mot de passe après clic sur le lien
     */
    public function resetPassword() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $token = $_POST['token'];
            $newPassword = $_POST['newPassword'];
            $confirmPassword = $_POST['confirmPassword'];

            if ($newPassword !== $confirmPassword) {
                echo "Les mots de passe ne correspondent pas.";
                return;
            }

            // Vérification du token
            $stmt = $this->db->query("SELECT idUser FROM users WHERE resetToken = ? AND resetTokenExpiry > NOW()", [$token]);
            $user = $stmt->fetch();

            if ($user) {
                // Hacher le nouveau mot de passe
                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

                // Mettre à jour le mot de passe et supprimer le token
                $this->db->query("UPDATE users SET password = ?, resetToken = NULL, resetTokenExpiry = NULL WHERE idUser = ?", [$hashedPassword, $user['idUser']]);

                echo "Mot de passe réinitialisé ! Vous pouvez maintenant vous connecter.";
            } else {
                echo "Lien invalide ou expiré.";
            }
        }
    }
}

