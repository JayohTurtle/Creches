<?php

include_once('AbstractEntityManager.php');

class InteretGroupeManager extends AbstractEntityManager{
    public $db;

    // Insère les interets avec l'id contact
    public function insertInteretGroupe($idContact, $niveau, $nom) {
        $sql = 'INSERT INTO interetgroupes(idContact, niveau, nom) 
                VALUES (:idContact, :niveau, :nom)';
        return $this->db->query($sql, [
            'idContact' => $idContact,
            'niveau' => $niveau,
            'nom' => $nom,
        ]);
    }

    public function getInteretGroupesByContact($idContact) {
        try {
            $sql = "SELECT i.niveau, c.nom
                    FROM interetgroupes i
                    JOIN contacts c ON i.idContact = c.idContact
                    WHERE i.idContact = :idContact";
    
            $query = $this->db->query($sql, ['idContact' => $idContact]);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
    
            $interets = [];
            foreach ($result as $row) {
                $interets[] = new InteretGroupe($row); // 🔥 On passe un tableau directement
            }
    
            return $interets; // On retourne les données
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
            FROM interetGroupes i
            JOIN contacts c ON i.idContact = c.idContact
            WHERE i.nom = :nom';

        // Exécute la requête via ton singleton
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