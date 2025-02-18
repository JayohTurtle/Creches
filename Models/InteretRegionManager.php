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

    public function getInteretRegionsByContact($idContact) {
        try {
            $sql = "SELECT ir.idContact, r.idRegion, r.region
                    FROM interetRegions ir
                    JOIN regions r ON ir.idRegion = r.idRegion
                    WHERE ir.idContact = :idContact";
    
            $query = $this->db->query($sql, ['idContact' => $idContact]);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
            $interetRegions = [];
            foreach ($result as $row) {
                // Création d'un objet Region
                $region = new Region();
                $region->setIdRegion($row['idRegion']);
                $region->setRegion($row['region']);
    
                // Création d'un objet InteretRegion
                $interetRegion = new InteretRegion();
                $interetRegion->setIdContact($row['idContact']);
                $interetRegion->setRegion($region);
    
                $interetRegions[] = $interetRegion;
            }
    
            return $interetRegions;
    
        } catch (PDOException $e) {
            return ["error" => "Erreur SQL : " . $e->getMessage()];
        }
    }
    
}