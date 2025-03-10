<?php

include_once('AbstractEntityManager.php');

class InteretRegionManager extends AbstractEntityManager{

    public function insertInteretRegion(InteretRegion $interetRegion) {
        // Récupérer les valeurs à partir de l'objet InteretRegion
        $idContact = $interetRegion->getIdContact();
        $idRegionInterest = $interetRegion->getIdRegion();
    
        // Requête SQL pour insérer les données
        $sql = 'INSERT INTO interetregion (idContact, idRegion) 
                VALUES (:idContact, :idRegion)';
    
        // Passer directement la requête à ton dbManager
        $result = $this->db->query($sql, [
            'idContact' => $idContact,
            'idRegion' => $idRegionInterest,
        ]);
    
        return $result;
    }

    public function getInteretsRegionsByContact($idContact) {

        $sql = "SELECT ir.idContact, r.idRegion, r.region
                FROM interetRegion ir
                JOIN regions r ON ir.idRegion = r.idRegion
                WHERE ir.idContact = :idContact";

        $query = $this->db->query($sql, ['idContact' => $idContact]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        $interetsRegions = [];
        foreach ($result as $row) {
            // Création d'un objet Region
            $region = new Region();
            $region->setIdRegion($row['idRegion']);
            $region->setRegion($row['region']);

            // Création d'un objet InteretRegion
            $interetRegion = new InteretRegion();
            $interetRegion->setIdContact($row['idContact']);
            $interetRegion->setRegion($region);

            $interetsRegions[] = $interetRegion;
        }

        return $interetsRegions;
    }
    
}