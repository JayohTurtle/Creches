<?php

include_once('AbstractEntityManager.php');

class InteretGroupeManager extends AbstractEntityManager{
    public $db;

    // Insère les interets avec l'id contact
    public function insertInteretGroupe($idContact, $niveau) {
        $sql = 'INSERT INTO interetgroupes(idContact, niveau) 
                VALUES (:idContact, :niveau)';
        return $this->db->query($sql, [
            'idContact' => $idContact,
            'niveau' => $niveau
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
}