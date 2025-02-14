<?php

include_once('AbstractEntityManager.php');

class InteretRegionManager extends AbstractEntityManager{
    public $db;

    // Insère les interets avec les id departement et contact
    public function insertInteretRegion($idContact, $idRegionInterest) {
        $sql = 'INSERT INTO interetregions (idContact, idRegion) 
                VALUES (:idContact, :idRegion)';
        return $this->db->query($sql, [
            'idContact' => $idContact,
            'idRegion' => $idRegionInterest,
        ]);
    }
}