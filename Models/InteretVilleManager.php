<?php

include_once('AbstractEntityManager.php');

class InteretVilleManager extends AbstractEntityManager{

    public function insertInteretVille(InteretVille $interetVille) {
        // Récupérer les valeurs à partir de l'objet InteretVille
        $idContact = $interetVille->getIdContact();
        $idVilleInterest = $interetVille->getIdVille();
        $rayon = $interetVille->getRayon();
    
        // Requête SQL pour insérer les données
        $sql = 'INSERT INTO interetville (idContact, idVille, rayon) 
                VALUES (:idContact, :idVille, :rayon)';
    
        // Passer directement la requête à ton dbManager
        $result = $this->db->query($sql, [
            'idContact' => $idContact,
            'idVille' => $idVilleInterest,
            'rayon' => (int) $rayon
        ]);
    
        return $result;
    }

    // Récupère les intérêts villes par contact
    public function getInteretsVillesByContact($idContact) {

        $sql = "SELECT iv.idContact, iv.rayon, v.idVille, v.ville
                FROM interetville iv
                JOIN villes v ON iv.idVille = v.idVille
                WHERE iv.idContact = :idContact";

        $query = $this->db->query($sql, ['idContact' => $idContact]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        $interetsVilles = [];
        foreach ($result as $row) {
            // Création d'un objet Ville
            $ville = new Ville();
            $ville->setIdVille($row['idVille']);
            $ville->setVille($row['ville']);

            // Création d'un objet InteretVille
            $interetVille = new InteretVille();
            $interetVille->setIdContact($row['idContact']);
            $interetVille->setRayon($row['rayon']);
            $interetVille->setVille($ville);

            $interetsVilles[] = $interetVille;
        }

        return $interetsVilles;
    }
}