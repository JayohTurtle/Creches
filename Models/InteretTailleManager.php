<?php

include_once('AbstractEntityManager.php');

class InteretTailleManager extends AbstractEntityManager{
    public $db;

    // Insère les interets avec les id ville et contact
    public function insertInteretTaille($idContact, $taille) {
        $sql = 'INSERT INTO interettaille (idContact, taille) 
                VALUES (:idContact, :taille)';
        return $this->db->query($sql, [
            'idContact' => $idContact,
            'taille' => $taille
        ]);
    }

    public function getInteretTailleByContact($idContact) {
        try {
            $sql = "SELECT taille FROM interetTaille WHERE idContact = :idContact";
    
            $query = $this->db->query($sql, ['idContact' => $idContact]);
            $result = $query->fetch(PDO::FETCH_ASSOC); // fetch() au lieu de fetchAll()
    
            if ($result) {
                return new InteretTaille($result);
            }
            return null; // Retourne null si aucun résultat trouvé
        } catch (Exception $e) {
            die("Erreur : " . $e->getMessage());
        }
    }
}
