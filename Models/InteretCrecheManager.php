<?php

include_once('AbstractEntityManager.php');

class InteretCrecheManager extends AbstractEntityManager {
    
public function insertInteretCreche($idContact, $niveau, $idIdentifiant) {
    // Vérifie si $niveau est vide (""), si oui, on arrête la fonction
    if ($niveau === "" || $niveau === null) {
        return; // Stoppe l'exécution
    }
        $sql = 'INSERT INTO interetcreches (idContact, niveau, idIdentifiant) 
                VALUES (:idContact, :niveau, :idIdentifiant)';
        $this->db->query($sql, [
            'idContact' => $idContact,
            'niveau' => $niveau,
            'idIdentifiant' => $idIdentifiant
        ]);
    }
}

