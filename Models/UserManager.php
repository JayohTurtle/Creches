<?php

include_once('AbstractEntityManager.php');

class UserManager extends AbstractEntityManager {

    public function createUser(string $email, string $password, string $role = "user") {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (email, password, role, mustChangePassword) VALUES (?, ?, ?, 1)";
        return $this->db->query($sql, [$email, $hashedPassword, $role]); // ✅ Utilisation correcte
    }

    public function getUserByEmail(string $email) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $result = $this->db->query($sql, [$email]); // ✅ Utilisation correcte

        return $result->fetch();
    }

    public function updatePassword(int $idUser, string $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $sql = "UPDATE users SET password = ?, mustChangePassword = 0 WHERE idUser = ?";
        
        return $this->db->query($sql, [$hashedPassword, $idUser]); // ✅ Utilisation correcte
    }
    

    public function verifyUserCredentials(string $email, string $password): ?User {
        $sql = "SELECT * FROM users WHERE email = ?";
        $result = $this->db->query($sql, [$email]);
        $userData = $result->fetch();
    
        if ($userData && password_verify($password, $userData['password'])) {
            // Création de l'objet utilisateur
            $user = new User();
            $user->setIdUser($userData['idUser']);
            $user->setEmail($userData['email']);
            $user->setPassword($userData['password']);
            $user->setRole($userData['role']);
            $user->setMustChangePassword($userData['mustChangePassword']);
            return $user;
        }
        return null;
    }
}


     
