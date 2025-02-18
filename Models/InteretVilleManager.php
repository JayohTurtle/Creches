<?php

include_once('AbstractEntityManager.php');

class InteretVilleManager extends AbstractEntityManager{
    public $db;

    // Insère les interets avec les id ville et contact
    public function insertInteretVille($idContact, $idVilleInterest, $rayon) {
        $sql = 'INSERT INTO interetvilles (idContact, idVille, rayon) 
                VALUES (:idContact, :idVille, :rayon)';
        return $this->db->query($sql, [
            'idContact' => $idContact,
            'idVille' => $idVilleInterest,
            'rayon' => (int) $rayon,
        ]);
    }
     // Récupère les intérêts villes par contact
    public function getInteretVillesByContact($idContact) {
        try {
            $sql = "SELECT iv.idContact, iv.rayon, v.idVille, v.ville
                    FROM interetvilles iv
                    JOIN villes v ON iv.idVille = v.idVille
                    WHERE iv.idContact = :idContact";
    
            $query = $this->db->query($sql, ['idContact' => $idContact]);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
            $interetVilles = [];
            foreach ($result as $row) {
                // Création d'un objet Ville
                $ville = new Ville();
                $ville->setIdVille($row['idVille']);
                $ville->setVille($row['ville']);
    
                // Création d'un objet InteretVille
                $interetVille = new InteretVille();
                $interetVille->setIdContact($row['idContact']);
                $interetVille->setRayon($row['rayon']);
                $interetVille->setVille($ville);
    
                $interetVilles[] = $interetVille;
            }
    
            return $interetVilles;
    
        } catch (PDOException $e) {
            return ["error" => "Erreur SQL : " . $e->getMessage()];
        }
    }
    
}
