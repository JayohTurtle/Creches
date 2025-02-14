<?php

include_once('AbstractEntityManager.php');

class InteretGroupeManager extends AbstractEntityManager{
    public $db;

    // Insère les interets avec l'id contact
    public function insertInteretGroupe($idContact, $niveau) {
        $sql = 'INSERT INTO interetgroupes(idContact, niveau) 
                VALUES (:idContact, :niveau)';
        return $this->db->query($sql, [
            'idContact' => $idContact,
            'niveau' => $niveau
        ]);
    }
}