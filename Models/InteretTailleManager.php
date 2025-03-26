<?php

include_once('AbstractEntityManager.php');

class InteretTailleManager extends AbstractEntityManager{

    public function insertInteretTaille(InteretTaille $interetTaille) {
        // Récupérer les valeurs à partir de l'objet InteretTaille
        $idContact = $interetTaille->getIdContact();
        $taille = $interetTaille->getTaille();
    
        // Requête SQL pour insérer les données
        $sql = 'INSERT INTO interettaille (idContact, taille) 
                VALUES (:idContact, :taille)';
    
        // Passer directement la requête à ton dbManager
        $result = $this->db->query($sql, [
            'idContact' => $idContact,
            'taille' => $taille
        ]);
        return $result;
    }

    //Fonction pour récupérer les données de la table interetTaille par contact
    public function getInteretTailleByIdContact($idContact) {
            
        $sql = "SELECT idContact, taille FROM interetTaille WHERE idContact = :idContact";
    
        $query = $this->db->query($sql, ['idContact' => $idContact]);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        if (!$result) {
            return null;
        }

        $interetTaille = new InteretTaille();
        $interetTaille->setIdContact($result['idContact']);
        $interetTaille->setTaille($result['taille']);

        return $interetTaille;
    }

    public function verifierEtMettreAJourTaille($idContact, $taille) {

        // Vérifier si la donnée existe déjà pour ce contact
        $sql = "SELECT taille FROM interetTaille WHERE idContact = :idContact";
        $contactActuel = $this->db->query($sql, [$idContact])->fetch(PDO::FETCH_ASSOC);
    
        if (!$contactActuel) {
            return ["status" => "error", "message" => "Contact introuvable."];
        }
    
        $valeurExistante = $contactActuel['taille'];
    
        // Si la valeur est identique, ne rien faire
        if ($valeurExistante === $taille) {
            return ["status" => "no_change", "message" => "Aucune modification nécessaire."];
        }
    
        // Si le champ est vide, mettre à jour directement
        if (empty($valeurExistante)) {
            $this->mettreAJourInteretTaille($idContact, $taille);
            return ["status" => "success", "message" => "Donnée mise à jour avec succès."];
        }
    
        // Si une modification est nécessaire, demander confirmation
        return [
            "status" => "confirm_required",
            "message" => "Une modification est détectée, confirmation requise.",
            "champ" => 'taille',
            "ancien" => $valeurExistante,
            "nouveau" => $taille,
            "idContact" => $idContact
        ];
    }

    public function mettreAJourInteretTaille($idContact, $taille) {
        // Mise à jour du champ "taille" dans interetTaille
        $sql = "UPDATE interetTaille SET taille = ? WHERE idContact = ?";
        $this->db->query($sql, [$taille, $idContact]);
    
        return ["status" => "success", "message" => "Taille modifiée avec succès."];
    }
    
}