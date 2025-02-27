<?php

include_once('AbstractEntityManager.php');

class InteretCrecheManager extends AbstractEntityManager {

    public $db;

    // Insère les interets avec les id identifiant et contact
    
public function insertInteretCreche($idContact, $niveau, $idIdentifiant) {
    // Vérifie si $niveau est vide (""), si oui, on arrête la fonction
    if ($niveau === "" || $niveau === null) {
        return; // Stoppe l'exécution
    }
        $sql = 'INSERT INTO interetcreches (idContact, niveau, idIdentifiant) 
                VALUES (:idContact, :niveau, :idIdentifiant)';
        $result =$this->db->query($sql, [
            'idContact' => $idContact,
            'niveau' => $niveau,
            'idIdentifiant' => $idIdentifiant
        ]);

        return $result; // Assure que la fonction retourne un booléen
    }

    public function getInteretCrechesByContact($idContact) {
        try {
            $sql = "SELECT i.niveau, l.identifiant
                    FROM interetCreches i
                    JOIN localisations l ON i.idIdentifiant = l.idLocalisation
                    WHERE i.idContact = :idContact";

    
            $query = $this->db->query($sql, ['idContact' => $idContact]);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
            $interets = [];
            foreach ($result as $row) {
                $interets[] = new InteretCreche($row); // 🔥 On passe un tableau
            }
    
            return $interets;
    
        } catch (PDOException $e) {
            return [];
        }
    }

    public function getContactsByIdentifiant($identifiant)
    {
        $sql = 'SELECT 
                    c.idContact, 
                    c.contact,
                    c.nom, 
                    c.telephone, 
                    c.email, 
                    i.niveau, 
                    l.identifiant
                FROM interetCreches i
                JOIN contacts c ON i.idContact = c.idContact
                JOIN localisations l ON i.idIdentifiant = l.idLocalisation
                WHERE l.identifiant = :identifiant';

        $stmt = $this->db->query($sql, [':identifiant' => $identifiant]);

        $contacts = [];
        while ($row = $stmt->fetch()) {
            $contact = new Contact([
                'idContact' => $row['idContact'],
                'contact'=> $row['contact'],
                'nom' => $row['nom'],
                'telephone' => $row['telephone'],
                'email' => $row['email'],
                'niveau' => $row['niveau'],
                'identifiant' => $row['identifiant'] // ici on récupère l'identifiant de la crèche
            ]);
            $contacts[] = $contact;
        }
        
        return $contacts;
    }

    // Méthode pour obtenir le nombre de crèches associées à un contact
    public function getNbCrechesByContactId($idContact) {
        // Requête pour compter le nombre de crèches pour ce contact
        $query = "SELECT COUNT(*) AS nbCreches
                    FROM localisations
                    WHERE idContact = :idContact";

        // Utilisation du gestionnaire de DB pour exécuter la requête et obtenir les résultats sous forme de tableau
        $stmt = DBManager::getInstance()->query($query, ['idContact' => $idContact]);

        // Récupérer le résultat sous forme de tableau
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Retourne le nombre de crèches ou 0 si aucune crèche n'est trouvée
        return $result['nbCreches'] ?? 0;
    }

     // Méthode pour vérifier si un contact est intéressé par le département de la crèche
     public function isContactInterestedInCrecheDepartment($idContact, $identifiantCreche) {
        // Requête pour obtenir l'ID du département associé à la crèche
        $sql = "
            SELECT l.idDepartement
            FROM localisations l
            WHERE l.identifiant = :identifiant
        ";

        // Exécuter la requête pour récupérer l'ID du département
        $this->db->query($sql, ['identifiant' => $identifiantCreche]);

        // Récupérer l'ID du département de la crèche
        $departement = $this->db->fetch(PDO::FETCH_ASSOC);

        if ($departement) {
            // Si on trouve un département, on vérifie dans la table interetdepartements si ce contact est intéressé
            $sql = "
                SELECT COUNT(*) AS interestCount
                FROM interetdepartements i
                WHERE i.idContact = :idContact
                  AND i.idDepartement = :idDepartement
            ";

            // Exécuter la requête de vérification d'intérêt du contact pour ce département
            $stmt = $this->db->query($sql, [
                'idContact' => $idContact,
                'idDepartement' => $departement['idDepartement']
            ]);

            // Récupérer le résultat
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // Si interestCount > 0, cela signifie que le contact est intéressé par ce département
            return $result['interestCount'] > 0;
        }

        return false;  // Si aucun département n'est trouvé, on retourne false
    }

    // Vérifier si un contact est interessé par un département
    public function isContactInterestedInDepartment($idContact, $idDepartement) {
        // Requête SQL pour vérifier si le contact est intéressé par ce département
        $sql = "SELECT COUNT(*) as interestCount 
                FROM interetdepartements 
                WHERE idContact = :idContact 
                AND idDepartement = :idDepartement";

        // Exécuter la requête avec les paramètres
        $stmt = $this->db->query($sql, [
            'idContact' => $idContact,
            'idDepartement' => $idDepartement
        ]);

        // Récupérer le résultat
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si interestCount > 0, cela signifie que le contact est intéressé par ce département
        return $result['interestCount'] > 0;
    }

    // Vérifier si un contact est interessé par une ville
    public function isContactInterestedInCity($idContact, $idVille) {
        // Requête SQL pour vérifier si le contact est intéressé par ce département
        $sql = "SELECT COUNT(*) as interestCount 
                FROM interetvilles
                WHERE idContact = :idContact 
                AND idVille = :idVille";

        // Exécuter la requête avec les paramètres
        $stmt = $this->db->query($sql, [
            'idContact' => $idContact,
            'idVille' => $idVille
        ]);

        // Récupérer le résultat
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Si interestCount > 0, cela signifie que le contact est intéressé par ce département
        return $result['interestCount'] > 0;
    }

}


    