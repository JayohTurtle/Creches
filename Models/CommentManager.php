<?php

include_once('AbstractEntityManager.php');

class CommentManager extends AbstractEntityManager {
    
    public function insertComment($idContact, $commentaire, $dateComment, $operateur) {
        if (!empty($commentaire)) {
            $sql = 'INSERT INTO commentaires (idContact, commentaire, date_comment, operateur) 
                    VALUES (:idContact, :commentaire, :date_comment, :operateur)';
            $this->db->query($sql, [
                'idContact' => $idContact,
                'commentaire' => $commentaire,
                'date_comment' => $dateComment,
                'operateur' => $operateur
            ]);
        }
    }
}
