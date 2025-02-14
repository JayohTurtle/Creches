<?php

include_once('AbstractEntityManager.php');

class InteretFranceManager extends AbstractEntityManager{
    public $db;

    // Insère les interets avec l'id contact
    public function insertInteretFrance($idContact) {
        $sql = 'INSERT INTO interetfrance(idContact) 
                VALUES (:idContact)';
        return $this->db->query($sql, [
            'idContact' => $idContact,
        ]);
    }
}