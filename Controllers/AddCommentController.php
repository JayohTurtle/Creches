<?php
class AddCommentController {
    private $commentManager;

    public function __construct() {

        $this->commentManager = new CommentManager();
    }

    public function handleAddComment() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $operateur = $_SESSION['user_email'];
            $dateComment = date('Y-m-d');
            $commentaire = $this->sanitizeInput($_POST['addComment'] ?? '');
            $idContact = $_POST['idContact'];

            $result = $this->commentManager->insertComment($idContact, $commentaire, $dateComment, $operateur);

            if ($result) {
                // Réponse en cas de succès
                echo json_encode(['status' => 'success', 'message' => 'Commentaire ajouté avec succès']);
            } else {
                // Si l'insertion a échoué
                echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'ajout du commentaire']);
            }

        }
    }


 /**
     * Fonction utilitaire pour nettoyer les entrées utilisateur.
     */
    private function sanitizeInput($input) {
        if (is_array($input)) {
            return array_map([$this, 'sanitizeInput'], $input);
        }
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }
    
}