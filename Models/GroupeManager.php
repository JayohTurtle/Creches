<?php

include_once('AbstractEntityManager.php');
class GroupeManager extends AbstractEntityManager {

    //Fonction qui permet de récupérer les groupes à vendre
    public function getGroupesAVendre(){
        $sql = "SELECT c.idContact,
            g.nom
        FROM clients c
        JOIN groupes g ON c.idContact = g.idContact
        WHERE c.statut = 'Mandat signé'";

        $result = $this->db->query($sql); // Exécution de la requête

        $groupesAVendre=[];
        while ($nom = $result -> fetch()){
            $groupesAVendre[] = new Groupe ($nom);
        }
        return $groupesAVendre;
    }

    //Fonction qui permet d'insérer un groupe

    public function insertGroupe(Groupe $groupe) {
        // Récupérer les valeurs à partir de l'objet Groupe
        $nom = $groupe->getNom();  
        $idContact = $groupe->getIdContact();  
    
        $sql = 'INSERT INTO groupes (nom, idContact) 
                VALUES (:nom, :idContact)';
    
        // Exécuter la requête
        $this->db->query($sql, [
            'nom' => $nom,
            'idContact' => $idContact
        ]);
    
        // Récupérer et retourner le dernier ID inséré
        return $this->db->lastInsertId();
    }

    public function getIdGroupeByName($nom) {
        $sql = "SELECT idGroupe FROM groupes WHERE nom = :nom";
        
        $query = $this->db->query($sql, ['nom' => $nom]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
    
        return $result ? $result['idGroupe'] : null; // Retourne idGroupe ou null si non trouvé
    }

}