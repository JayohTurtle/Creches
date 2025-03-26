<?php

include_once('AbstractEntityManager.php');

class CommentManager extends AbstractEntityManager {

    //Fonction pour insérer un commentaire
    public function insertComment(Comment $comment) {
        if (!empty($comment->getCommentaire())) {
            $sql = 'INSERT INTO commentaires (idContact, commentaire, dateComment, operateur) 
                    VALUES (:idContact, :commentaire, :dateComment, :operateur)';
            return $this->db->query($sql, [
                'idContact' => $comment->getIdContact(),
                'commentaire' => $comment->getCommentaire(),
                'dateComment' => $comment->getDateComment(),
                'operateur' => $comment->getOperateur()
            ]);
        }
    }

    //Fonction pour récupérer les commentaires d'un contact
    public function getCommentsByIdContact($idContact) {
        $sql = 'SELECT * FROM commentaires WHERE idContact = :idContact';
        $stmt = $this->db->query($sql, ['idContact' => $idContact]);
    
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupérer toutes les lignes
    
        if (!$results) {
            return []; // Aucun commentaire
        }
    
        // Transformer en tableau d'objets comment`
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