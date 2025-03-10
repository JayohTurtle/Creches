<?php

include_once('AbstractEntityManager.php');

class InteretVilleManager extends AbstractEntityManager{

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

    public function insertInteretVille(InteretVille $interetVille) {
        // Récupérer les valeurs à partir de l'objet InteretVille
        $idContact = $interetVille->getIdContact();
        $idVilleInterest = $interetVille->getIdVille();
        $rayon = $interetVille->getRayon();
    
        // Requête SQL pour insérer les données
        $sql = 'INSERT INTO interetville (idContact, idVille, rayon) 
                VALUES (:idContact, :idVille, :rayon)';
    
        // Passer directement la requête à ton dbManager
        $result = $this->db->query($sql, [
            'idContact' => $idContact,
            'idVille' => $idVilleInterest,
            'rayon' => (int) $rayon
        ]);
    
        return $result;
    }

    // Récupère les intérêts villes par contact
    public function getInteretsVillesByContact($idContact) {

        $sql = "SELECT iv.idContact, iv.rayon, v.idVille, v.ville
                FROM interetville iv
                JOIN villes v ON iv.idVille = v.idVille
                WHERE iv.idContact = :idContact";

        $query = $this->db->query($sql, ['idContact' => $idContact]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        $interetsVilles = [];
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

            $interetsVilles[] = $interetVille;
        }

        return $interetsVilles;
    }
}
