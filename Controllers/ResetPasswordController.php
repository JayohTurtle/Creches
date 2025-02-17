<?php
require 'vendor/autoload.php';  
use PHPMailer\PHPMailer\PHPMailer;  
use PHPMailer\PHPMailer\Exception;

class ResetPasswordController {
    public $db;

    public function __construct() {
        $this->db = DBManager::getInstance();
    }

    public function showForgotPasswordForm() {
        $view = new View();
        $view->render("forgotPassword", []);
    }

    public function sendResetLink() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {      
            $email = trim($_POST['email']);
            $stmt = $this->db->query("SELECT idUser FROM users WHERE email = ?", [$email]);
            $user = $stmt->fetch();
    
            if ($user) {
                $token = bin2hex(random_bytes(32));
                $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));
    
                $this->db->query("UPDATE users SET reset_token = ?, token_expiration = ? WHERE idUser = ?", [$token, $expiry, $user['idUser']]);
    
                $resetLink = "http://localhost/creches/index.php?action=resetPassword&token=$token";

                try {
                    
                    $mail = new PHPMailer(true);
                    $mail->isSMTP();
                    $mail->Host = 'mail.gandi.net'; 
                    $mail->SMTPAuth = true;
                    $mail->Username = getenv('SMTP_USER');  // Ton adresse email complète
                    $mail->Password = getenv('SMTP_PASSWORD');  // Ton mot de passe email
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // STARTTLS recommandé
                    $mail->Port = 587; // Port 587 avec STARTTLS ou 465 avec SSL

                    $mail->setFrom(getenv('SMTP_USER'), 'Support Creches');
                    $mail->addAddress($email);

                    $mail->Subject = "Réinitialisation de votre mot de passe";
                    $mail->Body = "Cliquez sur ce lien pour réinitialiser votre mot de passe : $resetLink";

                    if ($mail->send()) {
                        $_SESSION['success_message'] = "Un email de réinitialisation a été envoyé.";
                    } else {
                        $_SESSION['error_message'] = "Erreur d'envoi de l'email.";
                    }
                } catch (Exception $e) {
                    $_SESSION['error_message'] = "Erreur d'envoi de l'email : {$mail->ErrorInfo}";
                }

    
            // Redirige après traitement
            header("Location: index.php?action=forgotPassword&success=1");
            exit();
            }

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
}
?>
