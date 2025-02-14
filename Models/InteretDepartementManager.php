<?php

include_once('AbstractEntityManager.php');

class InteretDepartementManager extends AbstractEntityManager{
    public $db;

    // Insère les interets avec les id departement et contact
    public function insertInteretDepartement($idContact, $idDepartementInterest) {
        $sql = 'INSERT INTO interetdepartements (idContact, idDepartement) 
                VALUES (:idContact, :idDepartement)';
        return $this->db->query($sql, [
            'idContact' => $idContact,
            'idDepartement' => $idDepartementInterest,
        ]);
    }
}