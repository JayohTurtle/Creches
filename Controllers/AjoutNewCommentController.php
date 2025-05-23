<?php
class AjoutNewCommentController {
    private $commentManager;

    public function __construct() {

        $this->commentManager = new CommentManager();
    }

    public function handleAjoutNewComment() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $operateur = $_SESSION['userEmail'];
            $dateComment = date('Y-m-d');
            $commentaire = $this->sanitizeInput($_POST['addComment'] ?? '');
            $idContact = $_POST['idContact'];

            $comment = new Comment([
                'idContact' => $idContact,
                'commentaire' => $commentaire,
                'operateur' => $operateur,
                'dateComment' => $dateComment
            ]);
            
            $result = $this->commentManager->insertComment($comment);

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
            return array_map([$this, 'sanitizeInput'], $input); // Nettoie les entrées dans les tableaux
        }
        return trim($input); // Supprime simplement les espaces inutiles
    }

}