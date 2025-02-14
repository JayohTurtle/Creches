<?php

include_once('AbstractEntityManager.php');

class DepartementManager extends AbstractEntityManager{

    function getDepartements(){
        $request = "select * from departements";
        $statement = $this -> db -> query($request);

        $departementList=[];
        while ($departement = $statement -> fetch()){
            $departementList[] = new Departement ($departement);
        }
        return $departementList;
    }
        

    //Récupère l'id du département par le code postal renseigné dans le formulaire
    public function getDepartementIdByCodePostal($codePostal) {
        // Extraire les deux premiers caractères du code postal
        $code= substr($codePostal, 0, 2);
    
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
    
        return $query->fetchColumn(); // Retourne l'ID du département
    }

    public function getDepartementIdByName($departement){
        $sql = 'SELECT idDepartement FROM departements WHERE departement = :departement';
        $query = $this->db->query($sql, ['departement' => $departement]);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        return $result ? (int) $result['idDepartement'] : null;
    
        return $query->fetchColumn(); // Retourne l'ID du département
    }
}
