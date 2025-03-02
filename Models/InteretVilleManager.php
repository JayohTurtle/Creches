<?php

include_once('AbstractEntityManager.php');

class InteretVilleManager extends AbstractEntityManager{
    public $db;

    // Insère les interets avec les id ville et contact
    public function insertInteretVille($idContact, $idVilleInterest, $rayon) {
        $sql = 'INSERT INTO interetville (idContact, idVille, rayon) 
                VALUES (:idContact, :idVille, :rayon)';
                return $this->db->query($sql, [
                'idContact' => $idContact,
                'idVille' => $idVilleInterest,
                'rayon' => (int) $rayon,
            ]);

            $result =$this->db->query($sql, [
                'idContact' => $idContact,
                'niveau' => $niveau,
                'idIdentifiant' => $idIdentifiant
            ]);

            return $result;
        }


     // Récupère les intérêts villes par contact
    public function getInteretVillesByContact($idContact) {
        try {
            $sql = "SELECT iv.idContact, iv.rayon, v.idVille, v.ville
                    FROM interetville iv
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

    public function getIdVilleByName($ville){

    $sql = 'SELECT idVille FROM villes WHERE ville = :ville';

    // Exécute la requête via ton singleton
    $stmt = $this->db->query($sql, [':ville' => $ville]);

    // Récupérer le résultat
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row ? $row['idVille'] : null; // Retourne l'idVille ou null si non trouvé

    }

    public function getInteretVilleById($idVille){
        try {
            $sql = "SELECT c.idContact, 
                    c.contact, 
                    c.nom, 
                    c.telephone, 
                    c.email, 
                    iv.rayon
                    FROM interetVille iv
                    JOIN contacts c ON iv.idContact = c.idContact
                    WHERE iv.idVille = :idVille";

            } catch (PDOException $e) {
                return ["error" => "Erreur SQL : " . $e->getMessage()];
            }

            $stmt = $this->db->query($sql, [':idVille' => $idVille]);

            $contacts = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $contacts[] = new Contact([
                    'idContact' => $row['idContact'],
                    'contact' => $row['contact'],
                    'nom' => $row['nom'], 
                    'telephone' => $row['telephone'],
                    'email' => $row['email'],
                ]);
            }

    }
    
}
