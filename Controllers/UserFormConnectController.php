<?php

class UserFormConnectController {    
    
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

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            // Récupère l'utilisateur en base de données
            $user = $this->userManager->getUserByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['idUser'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                $_SESSION['user'] = $user; // Stocke l'utilisateur dans la session

                // Si l'utilisateur doit changer son mot de passe, on le redirige
                if ($user['must_change_password']) {
                    $view = new View();
                    $view->render("changePassword", []);
                    exit();
                }
                header("Location: index.php?action=dashboard");
                exit();
            } else {
                echo "Email ou mot de passe incorrect.";
            }
        }
    }
}

