<?php

include_once('AbstractEntityManager.php');

class VilleManager extends AbstractEntityManager{

    function getVilles(){
        $request = "select * from villes";
        $statement = $this -> db -> query($request);

        $villeList=[];
        while ($ville = $statement -> fetch()){
            $villeList[] = new Ville ($ville);
        }
        return $villeList;
        
    }
    
    public function getVilleIdByName($ville) {
        $sql = 'SELECT idVille FROM villes WHERE ville = :ville';
        $query = $this->db->query($sql, ['ville' => $ville]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
    
        return $result ? (int) $result['idVille'] : null;
    }
    

    public function insertVilleIfNotExists($ville, $codePostal, $idDepartement) {
        $sql = 'SELECT idVille FROM villes WHERE ville = :ville AND codePostal = :codePostal AND idDepartement = :idDepartement';
        $idVille = (int) $this->db->query($sql, ['ville' => $ville, 'codePostal' => $codePostal, 'idDepartement' => $idDepartement])->fetchColumn();
    
        if (!$idVille) {
            $sql = 'INSERT INTO villes (ville, codePostal, idDepartement) VALUES (:ville, :codePostal, :idDepartement)';
            $this->db->query($sql, ['ville' => $ville, 'codePostal' => $codePostal, 'idDepartement' => $idDepartement]);
            $idVille = (int) $this->db->lastInsertId(); // Récupère l'ID inséré
        }
    
        return $idVille;
    }

    public function getVilleIdByIdentifiant($identifiant) {
        // Préparer la requête pour récupérer l'idVille pour l'identifiant donné
        $sql = "SELECT idVille FROM localisations WHERE identifiant = :identifiant";
        $stmt = $this->db->query($sql, ['identifiant' => $identifiant]);
    
        // Récupérer le résultat
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Retourner l'ID du département ou null si aucun résultat
        return $result ? $result['idVille'] : null;
    }

    public function getVilleNameById($idVille){
        $sql = 'SELECT ville FROM villes WHERE idVille = :idVille';
        $query = $this->db->query($sql, ['idVille' => $idVille]);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['ville'] : null;
    }
    
}
