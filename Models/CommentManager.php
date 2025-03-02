<?php

include_once('AbstractEntityManager.php');

class CommentManager extends AbstractEntityManager {
    
    public function insertComment($idContact, $commentaire, $dateComment, $operateur) {
        if (!empty($commentaire)) {
            $sql = 'INSERT INTO commentaires (idContact, commentaire, dateComment, operateur) 
                    VALUES (:idContact, :commentaire, :dateComment, :operateur)';
            return $this->db->query($sql, [
                'idContact' => $idContact,
                'commentaire' => $commentaire,
                'dateComment' => $dateComment,
                'operateur' => $operateur
            ]);
        }
    }

    public function extractComments($idContact) {
        $sql = 'SELECT * FROM commentaires WHERE idContact = :idContact';
        $stmt = $this->db->query($sql, ['idContact' => $idContact]);
    
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupérer toutes les lignes
    
        if (!$results) {
            return []; // Aucun commentaire
        }
    
        // Transformer en objets `Comment`
        $comments = [];
        foreach ($results as $row) {
            $comment = new Comment();
            $comment->setCommentaire($row['commentaire'] ?? '');
            $comment->setDateComment($row['dateComment'] ?? '');
            $comment->setOperateur($row['operateur'] ?? '');
            
            $comments[] = $comment;
        }
    
        return $comments;
    }
    
}
