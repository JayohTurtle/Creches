<?php

include_once('AbstractEntityManager.php');

class InteretFranceManager extends AbstractEntityManager{
    public $db;

    // Insère les interets avec l'id contact
    public function insertInteretFrance($idContact) {
        $sql = 'INSERT INTO interetfrance(idContact) 
                VALUES (:idContact)';
        $result = $this->db->query($sql, [
            'idContact' => $idContact,
        ]);

        return $result;
    }

    public function hasInteretFrance($idContact) {

        $sql = "SELECT COUNT(*) as existe FROM interetFrance WHERE idContact = :idContact";
        $query = $this->db->query($sql, ['idContact' => $idContact]);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        return $result['existe'] > 0; // Retourne true si le contact a un intérêt pour la France
    }
}