<?php
require 'vendor/autoload.php';  
use PHPMailer\PHPMailer\PHPMailer;  
use PHPMailer\PHPMailer\Exception;

class ResetPasswordController {
    private $db;

    public function __construct() {
        $this->db = DBManager::getInstance();
    }

    public function showForgotPasswordForm() {
        $view = new View();
        $view->render("forgotPassword", []);
    }

    public function sendResetLink() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {      
            $emailUser = $this->sanitizeInput($_POST['email']);

            // Vérifie si l'email existe dans la base de données
            $stmt = $this->db->query("SELECT idUser FROM users WHERE email = ?", [$emailUser]);
            $user = $stmt->fetch();
    
            if ($user) {
                // Génération du token sécurisé
                $token = bin2hex(random_bytes(32));
                $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

                // Met à jour le token en base de données
                $this->db->query("UPDATE users SET reset_token = ?, token_expiration = ? WHERE idUser = ?", 
                                 [$token, $expiry, $user['idUser']]);

                // Création du lien de réinitialisation
                $resetLink = "http://localhost/creches/index.php?action=resetPassword&token=$token";

                // Envoi de l'email via PHPMailer
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );
                    $mail->Host = $_ENV['SMTP_HOST'];
                    $mail->Username = $_ENV['SMTP_USER'];
                    $mail->Password = $_ENV['SMTP_PASSWORD'];
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = $_ENV['SMTP_PORT'];

                    $mail->setFrom($_ENV['SMTP_USER'], 'Support Crèches');
                    $mail->addAddress($emailUser);

                    $mail->Subject = "Réinitialisation de votre mot de passe";
                    $mail->Body = "Cliquez sur ce lien pour réinitialiser votre mot de passe : $resetLink";

                    if ($mail->send()) {
                        $_SESSION['success_message'] = "Si cet email existe, un lien de réinitialisation a été envoyé.";
                    } else {
                        $_SESSION['error_message'] = "Une erreur s'est produite lors de l'envoi du mail.";
                    }
                } catch (Exception $e) {
                    $_SESSION['error_message'] = "Erreur d'envoi du mail : " . $mail->ErrorInfo;
                }
            } else {
                // Toujours renvoyer un message générique pour ne pas révéler l'existence de l'email
                $_SESSION['success_message'] = "Si cet email existe, un lien de réinitialisation a été envoyé.";
            }

            // Redirige après traitement
            header("Location: index.php?action=forgotPassword&success=1");
            exit();
        }
    }
    
    public function showResetPasswordForm() {
        $view = new View();
        $view->render("resetPassword", ["token" => $_GET['token'] ?? '']);
    }

    public function resetPassword() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $token = $_POST['token'];
            $newPassword = $_POST['newPassword'];
            $confirmPassword = $_POST['confirmPassword'];

            if ($newPassword !== $confirmPassword) {
                $_SESSION['error_message'] = "Les mots de passe ne correspondent pas.";
                header("Location: index.php?action=resetPassword&token=$token");
                exit();
            }

            $stmt = $this->db->query("SELECT idUser FROM users WHERE reset_token = ? AND token_expiration > NOW()", [$token]);
            $user = $stmt->fetch();

            if ($user) {
                $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                $this->db->query("UPDATE users SET password = ?, reset_token = NULL, token_expiration = NULL WHERE idUser = ?", [$hashedPassword, $user['idUser']]);

                $_SESSION['success_message'] = "Mot de passe réinitialisé ! Vous pouvez vous connecter.";
                header("Location: index.php?action=userFormConnect");
                exit();
            } else {
                $_SESSION['error_message'] = "Lien invalide ou expiré.";
                header("Location: index.php?action=forgotPassword");
                exit();
            }
        }
    }
    /**
    * Fonction utilitaire pour nettoyer les entrées utilisateur.
    */
    private function sanitizeInput($input) {
        if (is_array($input)) {
            return array_map([$this, 'sanitizeInput'], $input); // Nettoie les entrées dans les tableaux
        }
        return trim($input); // Supprime simplement les espaces inutiles
    }
}

