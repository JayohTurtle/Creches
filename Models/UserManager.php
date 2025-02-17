<?php

include_once('AbstractEntityManager.php');

class UserManager extends AbstractEntityManager {

    public $db;

    public function __construct() {
        $this->db = DBManager::getInstance();
    }

    public function createUser(string $email, string $password, string $role = "user") {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (email, password, role, must_change_password) VALUES (?, ?, ?, 1)";
        return $this->db->query($sql, [$email, $hashedPassword, $role]); // ✅ Utilisation correcte
    }

    public function getUserByEmail(string $email) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->db->query($sql, [$email]); // ✅ Utilisation correcte

        return $stmt->fetch();
    }

    public function updatePassword(int $idUser, string $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $sql = "UPDATE users SET password = ?, must_change_password = 0 WHERE idUser = ?";
        
        return $this->db->query($sql, [$hashedPassword, $idUser]); // ✅ Utilisation correcte
    }
    

    public function verifyUserCredentials(string $email, string $password): ?User {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->db->query($sql, [$email]);
        $userData = $stmt->fetch();
    
        if ($userData && password_verify($password, $userData['password'])) {
            // Création de l'objet utilisateur
            $user = new User();
            $user->setIdUser($userData['idUser']);
            $user->setEmail($userData['email']);
            $user->setPassword($userData['password']);
    
            // Stocker l'utilisateur dans la session
            $_SESSION['user'] = [
                'id' => $user->getIdUser(),
                'email' => $user->getEmail(),
                'role' => $userData['role']
            ];
    
            // Vérifier si le mot de passe doit être changé
            if ($userData['must_change_password']) {
                $_SESSION['must_change_password'] = true;
                header("Location: changePassword.php");
                exit;
            }
    
            return $user;
        }
        return null;
    }
    
}


     
