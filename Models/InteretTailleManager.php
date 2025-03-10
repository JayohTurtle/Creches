<?php

include_once('AbstractEntityManager.php');

class InteretTailleManager extends AbstractEntityManager{

    public function insertInteretTaille(InteretTaille $interetTaille) {
        // Récupérer les valeurs à partir de l'objet InteretTaille
        $idContact = $interetTaille->getIdContact();
        $taille = $interetTaille->getTaille();
    
        // Requête SQL pour insérer les données
        $sql = 'INSERT INTO interettaille (idContact, taille) 
                VALUES (:idContact, :taille)';
    
        // Passer directement la requête à ton dbManager
        $result = $this->db->query($sql, [
            'idContact' => $idContact,
            'taille' => $taille
        ]);
        return $result;
    }

    public function getInteretTailleByContact($idContact) {
            
        $sql = "SELECT idContact, taille FROM interetTaille WHERE idContact = :idContact";
    
        $query = $this->db->query($sql, ['idContact' => $idContact]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        if (!$result) {
            return null;
        }

        $interetTaille = new InteretTaille();
        $interetTaille->setIdContact($result['idContact']);
        $interetTaille->setTaille($result['taille']);

        return $interetTaille;
    }
}
