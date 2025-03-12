<?php

include_once('AbstractEntityManager.php');

class DepartementManager extends AbstractEntityManager{

    //Récupère l'id du département par le code postal renseigné dans le formulaire
    public function getDepartementIdByCodePostal($codePostal) {

        // Extraire les deux premiers caractères du code postal
        $code= substr($codePostal, 0, 2);
        ;
        // Gestion des cas particuliers pour la Corse
        if ($code === '20') {
            if ($codePostal >= '20000' && $codePostal <= '20190') {
                $code = '2A'; // Corse du Sud
            } else {
                $code = '2B'; // Haute-Corse
            }
        }
    
        // Requête pour récupérer l'ID du département
        $sql = 'SELECT idDepartement FROM departements WHERE code = :code';
        $query = $this->db->query($sql, ['code' => $code]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
    
        return $result ? (int) $result['idDepartement'] : null;
    
    }

    public function getDepartementNameById($idDepartement){
        $sql = 'SELECT departement FROM departements WHERE idDepartement = :idDepartement';
        $query = $this->db->query($sql, ['idDepartement' => $idDepartement]);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        return $result ? $result['departement'] : null;
    }

    public function getDepartementIdByIdentifiant($identifiant) {
        // Préparer la requête pour récupérer l'idDepartement pour l'identifiant donné
        $sql = "SELECT idDepartement FROM localisations WHERE identifiant = :identifiant";
        $stmt = $this->db->query($sql, ['identifiant' => $identifiant]);
    
        // Récupérer le résultat
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Retourner l'ID du département ou null si aucun résultat
        return $result ? $result['idDepartement'] : null;
    }

    function getDepartements(){
        $request = "select * from departements";
        $statement = $this -> db -> query($request);

        $departementList=[];
        while ($departement = $statement -> fetch()){
            $departementList[] = new Departement ($departement);
        }
        return $departementList;
    }

    public function getDepartementsIdByIdRegion($idRegion) {
        $request = "SELECT idDepartement FROM departements WHERE idRegion = :idRegion";

        $result = $this -> db -> query($request,['idRegion' => $idRegion]);

        $idDepartementList=[];
        while ($idDepartement = $result -> fetch()){
            $idDepartementList[] = new Departement ($idDepartement);
        }
        return $idDepartementList;
    }

    public function getDepartementIdByName($departement){
        $sql = 'SELECT idDepartement FROM departements WHERE departement = :departement';
        $query = $this->db->query($sql, ['departement' => $departement]);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        return $result ? (int) $result['idDepartement'] : null;
    
    }
}

