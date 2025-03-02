<?php

include_once('AbstractEntityManager.php');

class InteretRegionManager extends AbstractEntityManager{
    public $db;

    // Insère les interets avec les id departement et contact
    public function insertInteretRegion($idContact, $idRegionInterest) {
        $sql = 'INSERT INTO interetregion (idContact, idRegion) 
                VALUES (:idContact, :idRegion)';
        $result = $this->db->query($sql, [
            'idContact' => $idContact,
            'idRegion' => $idRegionInterest,
        ]);

        return $result;
    }

    public function getInteretRegionsByContact($idContact) {
        try {
            $sql = "SELECT ir.idContact, r.idRegion, r.region
                    FROM interetRegion ir
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