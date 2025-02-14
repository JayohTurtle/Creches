<?php

include_once('AbstractEntityManager.php');

class InteretVilleManager extends AbstractEntityManager{
    public $db;

    // Insère les interets avec les id ville et contact
    public function insertInteretVille($idContact, $idVilleInterest, $rayon) {
        $sql = 'INSERT INTO interetvilles (idContact, idVille, rayon) 
                VALUES (:idContact, :idVille, :rayon)';
        return $this->db->query($sql, [
            'idContact' => $idContact,
            'idVille' => $idVilleInterest,
            'rayon' => (int) $rayon,
        ]);
    }
}
