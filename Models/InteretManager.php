<?php

include_once('AbstractEntityManager.php');

class InteretManager extends AbstractEntityManager{
    public $db;

    // Insère les interets avec les id ville, id identifiant, id contact, id departement
    public function insertInteret($idContact, $idVille, $idDepartement, $idRegion, $taille, $rayon) {
        $sql = 'INSERT INTO interets (idContact, idVille, idDepartement, idRegion, taille, rayon) 
                VALUES (:idContact, :idVille, :idDepartement, :idRegion, :taille, :rayon)';
        return $this->db->query($sql, [
            'idContact' => $idContact,
            'idVille' => $idVille ?? null,
            'idDepartement' => $idDepartement ?? null,
            'idRegion' => ($idRegion > 0) ? $idRegion : null, // Vérifie et force NULL
            'taille' => $taille,
            'rayon' => (int) $rayon,
        ]);
    }
    
}
