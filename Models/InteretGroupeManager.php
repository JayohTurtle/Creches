<?php

include_once('AbstractEntityManager.php');

class InteretGroupeManager extends AbstractEntityManager{
    public $db;

    public function insertInteretGroupe($idContact, $niveau, $nom) {
        if ($niveau === "" || $niveau === null) {
            return;
        }
    
        try {
            $sql = 'INSERT INTO interetgroupe (idContact, niveau, nom) 
                    VALUES (:idContact, :niveau, :nom)
                    ON DUPLICATE KEY UPDATE 
                        niveau = VALUES(niveau), 
                        date_colonne = IF(date_colonne IS NOT NULL, NOW(), date_colonne)';
    
            $query = $this->db->prepare($sql);
            $success = $query->execute([
                'idContact' => $idContact,
                'niveau' => $niveau,
                'nom' => $nom
            ]);
    
            if ($success) {
                return true;
            } else {
                throw new Exception("Échec de l'exécution SQL");
            }
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'error',
                'message' => "Erreur SQL : " . $e->getMessage()
            ]);
            exit;
        }
    }

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
    
    public function getInteretGroupesByContact($idContact) {
        try {
         $sql = "SELECT i.niveau, i.nom, i.date_colonne AS dateInteret
        FROM interetgroupe i
        JOIN contacts c ON i.idContact = c.idContact
        WHERE i.idContact = :idContact";
    
            $query = $this->db->query($sql, ['idContact' => $idContact]);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
            $interets = [];
            foreach ($result as $row) {
                $interets[] = new InteretGroupe($row);
            }
    
            return $interets;
        } catch (Exception $e) {
            die("Erreur : " . $e->getMessage());
        }
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

}