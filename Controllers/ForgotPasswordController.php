<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $this->sanitizeInput($_POST['email']);
    $db = DBManager::getInstance();

    $stmt = $db->query("SELECT idUser FROM users WHERE email = ?", [$email]);
    $user = $stmt->fetch();

    if ($user) {
        $token = bin2hex(random_bytes(32)); // Générer un token unique
        $expiry = date("Y-m-d H:i:s", strtotime("+1 hour")); // Expiration dans 1h

        // Enregistrer le token et l'expiration dans la base
        $db->query("UPDATE users SET resetToken = ?, resetTokenExpiry = ? WHERE idUser = ?", [$token, $expiry, $user['idUser']]);

        // Lien de réinitialisation
        $resetLink = "http://" . $_SERVER['HTTP_HOST'] . "/creches/resetPassword.php?token=$token";

        // Envoi d'email (remplace `votre-site.com` par ton domaine)
        mail($email, "Réinitialisation de mot de passe", "Cliquez sur ce lien pour réinitialiser votre mot de passe : $resetLink");

        echo "Un e-mail de réinitialisation vous a été envoyé.";
    } else {
        echo "Aucun compte associé à cet email.";
    }

}
/**
 * Fonction utilitaire pour nettoyer les entrées utilisateur destinées à la base de données.
 */
function sanitizeInput($input) {
    if (is_array($input)) {
        return array_map('sanitizeInput', $input); // Nettoie les entrées dans les tableaux
    }
    return trim($input); // Supprime simplement les espaces inutiles
}


