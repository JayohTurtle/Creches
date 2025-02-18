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

    public function getInteretCrechesByContact($idContact) {
        try {
            $sql = "SELECT i.niveau, l.identifiant
                    FROM interetCreches i
                    JOIN localisations l ON i.idIdentifiant = l.idLocalisation
                    WHERE i.idContact = :idContact";

    
            $query = $this->db->query($sql, ['idContact' => $idContact]);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
            $interets = [];
            foreach ($result as $row) {
                $interets[] = new InteretCreche($row); // 🔥 On passe un tableau
            }
    
            return $interets;
    
        } catch (PDOException $e) {
            return [];
        }
    }    
}

