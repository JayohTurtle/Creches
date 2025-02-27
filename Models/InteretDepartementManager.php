<?php

include_once('AbstractEntityManager.php');

class InteretDepartementManager extends AbstractEntityManager{
    public $db;

    // Insère les interets avec les id departement et contact
    public function insertInteretDepartement($idContact, $idDepartementInterest) {
        $sql = 'INSERT INTO interetdepartements (idContact, idDepartement) 
                VALUES (:idContact, :idDepartement)';
        $result = $this->db->query($sql, [
            'idContact' => $idContact,
            'idDepartement' => $idDepartementInterest,
        ]);

        return $result;
    }

    //Récupère le département par l'idContact
    public function getInteretDepartementsByContact($idContact) {
        try {
            $sql = "SELECT id.idContact, d.idDepartement, d.departement
                    FROM interetdepartements id
                    JOIN departements d ON id.idDepartement = d.idDepartement
                    WHERE id.idContact = :idContact";
    
            $query = $this->db->query($sql, ['idContact' => $idContact]);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
            $interetDepartements = [];
            foreach ($result as $row) {
                // Création d'un objet Departement
                $departement = new Departement();
                $departement->setIdDepartement($row['idDepartement']);
                $departement->setDepartement($row['departement']);
    
                // Création d'un objet InteretDepartement
                $interetDepartement = new InteretDepartement();
                $interetDepartement->setIdContact($row['idContact']);
                $interetDepartement->setDepartement($departement);
    
                $interetDepartements[] = $interetDepartement;
            }
    
            return $interetDepartements;
    
        } catch (PDOException $e) {
            return ["error" => "Erreur SQL : " . $e->getMessage()];
        }
    }
    
}