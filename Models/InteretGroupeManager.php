<?php

include_once('AbstractEntityManager.php');

class InteretGroupeManager extends AbstractEntityManager{

    public function insertInteretGroupe(InteretGroupe $interetGroupe) {
        // Récupérer les valeurs à partir de l'objet InteretGroupe
        $niveau = $interetGroupe->getNiveau();
        $idContact = $interetGroupe->getIdContact();
        $idGroupe= $interetGroupe->getIdGroupe();
        
        // Vérifier si le niveau est vide ou null
        if ($niveau === "" || $niveau === null) {
            return;
        }
        
        $sql = 'INSERT INTO interetgroupe (idGroupe, idContact, niveau) 
                VALUES (:idGroupe, :idContact, :niveau)
                ON DUPLICATE KEY UPDATE 
                    niveau = VALUES(niveau), 
                    date_colonne = IF(date_colonne IS NOT NULL, NOW(), date_colonne)';

        $result = $this->db->query($sql, [
            'idGroupe'=> $idGroupe,
            'idContact'=> $idContact,
            'niveau'=> $niveau,
            
        ]);
        return $result;
    }
}