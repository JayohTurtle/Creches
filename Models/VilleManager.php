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
    
}
