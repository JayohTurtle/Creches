<?php

include_once('AbstractEntityManager.php');

class InteretDepartementManager extends AbstractEntityManager{

    public function insertInteretDepartement(InteretDepartement $interetDepartement) {
        // Récupérer les valeurs à partir de l'objet InteretDepartement
        $idContact = $interetDepartement->getIdContact();
        $idDepartementInterest = $interetDepartement->getIdDepartement();
    
        // Requête SQL pour insérer les données
        $sql = 'INSERT INTO interetDepartement (idContact, idDepartement) 
                VALUES (:idContact, :idDepartement)';
    
        // Passer directement la requête à ton dbManager
        $result = $this->db->query($sql, [
            'idContact' => $idContact,
            'idDepartement' => $idDepartementInterest,
        ]);
    
        return $result;
    }

    //Récupère les intérêts par département d'un contact
    public function getInteretsDepartementsByIdContact($idContact) {

        $sql = "SELECT id.idContact, d.idDepartement, d.departement
                FROM interetDepartement id
                JOIN departements d ON id.idDepartement = d.idDepartement
                WHERE id.idContact = :idContact";

        $query = $this->db->query($sql, ['idContact' => $idContact]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        $interetsDepartements = [];
        foreach ($result as $row) {
            // Création d'un objet Departement
            $departement = new Departement();
            $departement->setIdDepartement($row['idDepartement']);
            $departement->setDepartement($row['departement']);

            // Création d'un objet InteretDepartement
            $interetDepartement = new InteretDepartement();
            $interetDepartement->setIdContact($row['idContact']);
            $interetDepartement->setDepartement($departement);

            $interetsDepartements[] = $interetDepartement;
        }

        return $interetsDepartements;
    }

    public function getIdContactByInteretDepartement($idZone){
        $sql = "SELECT idContact FROM interetDepartement WHERE idDepartement = :idZone";
        $result = $this->db->query($sql,['idZone' => $idZone]);
        
        return $result->fetchAll(PDO::FETCH_COLUMN);
    }
}