<?php

include_once('AbstractEntityManager.php');

class InteretGroupeManager extends AbstractEntityManager{
    public $db;

    
    

    public function getIdGroupeByName($nom){
        $sql = "SELECT i.niveau, i.idContact, i.date_colonne AS dateInteret
        FROM interetgroupe i
        WHERE i.nom = :nom";

        $query = $this->db->query($sql, ['nom' => $nom]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $interetsGroupe = [];
            foreach ($result as $row) {
                $interetsGroupe[] = new InteretGroupe($row);
            }

        return $interetsGroupe;

    }

    public function getContactsByGroupe($groupe)
    {
        $sql = 'SELECT 
                c.idContact, 
                c.contact,
                c.nom, 
                c.telephone, 
                c.email, 
                i.niveau
            FROM interetGroupe i
            JOIN contacts c ON i.idContact = c.idContact
            WHERE i.nom = :nom';

        $stmt = $this->db->query($sql, [':nom' => $groupe]);

        $contacts = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $contacts[] = new Contact([
                'idContact' => $row['idContact'],
                'contact' => $row['contact'],
                'nom' => $row['nom'], 
                'telephone' => $row['telephone'],
                'email' => $row['email'],
                'niveau' => $row['niveau'],
            ]);
        }

        return $contacts;
    }
    
    public function insertInteretGroupe(InteretGroupe $interetGroupe) {
        // Récupérer les valeurs à partir de l'objet InteretGroupe
        $niveau = $interetGroupe->getNiveau();
        $idContact = $interetGroupe->getIdContact();
        $nom = $interetGroupe->getNom();
    
        // Vérifier si le niveau est vide ou null
        if ($niveau === "" || $niveau === null) {
            return;
        }
        
        // Requête SQL pour insertion ou mise à jour
        $sql = 'INSERT INTO interetgroupe (idContact, niveau, nom) 
                VALUES (:idContact, :niveau, :nom)
                ON DUPLICATE KEY UPDATE 
                    niveau = VALUES(niveau), 
                    date_colonne = IF(date_colonne IS NOT NULL, NOW(), date_colonne)';

        // Passer directement la requête à ton dbManager
        $result = $this->db->query($sql, [
            'idContact' => $idContact,
            'niveau' => $niveau,
            'nom' => $nom
        ]);
        return $result;
    }

    public function getInteretsGroupesByIdContact($idContact) {

        $sql = "SELECT i.niveau, i.nom, i.date_colonne AS dateInteret
       FROM interetgroupe i
       JOIN contacts c ON i.idContact = c.idContact
       WHERE i.idContact = :idContact";
   
       $query = $this->db->query($sql, ['idContact' => $idContact]);
       $result = $query->fetchAll(PDO::FETCH_ASSOC);
       
       if(!$result){
           return null;
       }

       $interetsGroupes = [];
       foreach ($result as $row) {
           $interetsGroupes[] = new InteretGroupe($row);
       }
       
       return $interetsGroupes;
   }

}