<?php

include_once('AbstractEntityManager.php');

class LocalisationManager extends AbstractEntityManager{
    public $db;

    function getLocalisations(){
        $request = "select * from localisations";
        $statement = $this -> db -> query($request);

        $localisationList=[];
        while ($localisation = $statement -> fetch()){
            $localisationList[] = new Localisation ($localisation);
        }
        return $localisationList;
    }

    // Insère la localisation avec les ID ville et département
    public function insertLocalisation($idContact, $idVille, $adresse, $idDepartement, $identifiant, $taille) {
        // Vérifier si l'identifiant existe déjà
        $sqlCheck = 'SELECT COUNT(*) FROM localisations WHERE identifiant = :identifiant';
        $stmt = $this->db->query($sqlCheck, ['identifiant' => $identifiant]);
        $exists = $stmt->fetchColumn();
    
        if ($exists > 0) {
            return; // Évite l'insertion d'un doublon
        }
    
        // Insérer si l'identifiant n'existe pas encore
        $sql = 'INSERT INTO localisations (idContact, idVille, adresse, idDepartement, identifiant, taille) 
                VALUES (:idContact, :idVille, :adresse, :idDepartement, :identifiant, :taille)';
        
        $this->db->query($sql, [
            'idContact' => $idContact,
            'idVille' => $idVille,
            'adresse' => $adresse,
            'idDepartement' => $idDepartement,
            'identifiant' => $identifiant,
            'taille' => $taille
        ]);
    }

    //Récupére l'id d'un identifiant
    public function getIdLocalisationByIdentifiant($identifiant) {
        $sql = "SELECT idLocalisation FROM localisations WHERE identifiant = :identifiant LIMIT 1";
        $stmt = $this->db->prepare($sql);  // Prépare la requête SQL
        $stmt->execute(['identifiant' => $identifiant]);  // Exécute avec la valeur de l'identifiant
        return $stmt->fetchColumn();  // Retourne l'ID de la localisation
    }
}




