<?php

include_once('AbstractEntityManager.php');

class GroupeManager extends AbstractEntityManager {

    public function getIdGroupeByName($groupe) {
        $sql = "SELECT idGroupe FROM groupes WHERE groupe = :nomGroupe";
        
        $query = $this->db->query($sql, ['nomGroupe' => $groupe]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
    
        return $result ? $result['idGroupe'] : null; // Retourne idGroupe ou null si non trouvé
    }

    public function insertGroupe(Groupe $groupe) {
        // Récupérer les valeurs à partir de l'objet Groupe
        $nomGroupe = $groupe->getGroupe();  
        $idContact = $groupe->getIdContact();  
    
        $sql = 'INSERT INTO groupes (groupe, idContact) 
                VALUES (:groupe, :idContact)';
    
        // Exécuter la requête
        $this->db->query($sql, [
            'groupe' => $nomGroupe,
            'idContact' => $idContact
        ]);
    
        // Récupérer et retourner le dernier ID inséré
        return $this->db->lastInsertId();
    }
}