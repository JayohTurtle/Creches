<?php

include_once('AbstractEntityManager.php');

class ContactManager extends AbstractEntityManager {

    // Ajouter un contact en base UUU
    public function insertContact(Contact $contact) {
        $sql = 'INSERT INTO contacts(nom, contact, siren, email, telephone, siteInternet, sens) 
                VALUES (:nom, :contact, :siren, :email, :telephone, :siteInternet, :sens)';
        
        $this->db->query($sql, [
            'nom' => $contact->getNom(),
            'contact' => $contact->getContact(),
            'siren' => $contact->getSiren(),
            'email' => $contact->getEmail(),
            'telephone' => $contact->getTelephone(),
            'siteInternet' => $contact->getSiteInternet(),
            'sens' => $contact->getSens()
        ]);
    
        return $this->db->lastInsertId();
    }

    function getContacts(){
        $request = "SELECT * FROM contacts";
        $result = $this -> db -> query($request);

        $contactList=[];
        while ($contact = $result -> fetch()){
            $contactList[] = new contact ($contact);
        }
        return $contactList;
    }

    // Vérifier si le contact existe déjà
    public function contactExists($nom, $contact, $email) {
        $sql = 'SELECT idContact FROM contacts 
                WHERE (nom = :nom AND email = :email) 
                   OR (contact = :contact AND email = :email2) 
                LIMIT 1';
    
        $query = $this->db->query($sql, [
            'nom' => $nom,
            'contact' => $contact,
            'email' => $email,
            'email2' => $email
        ]);
    
        return (bool) $query->fetchColumn(); // Retourne true si un contact est trouvé, sinon false
    }

    function getAcheteurs(){
        $request = "SELECT * FROM contacts WHERE sens = 'acheteur' OR sens = 'acheteur/vendeur'"; 
        $result = $this -> db -> query($request);

        $contactList=[];
        while ($contact = $result -> fetch()){
            $contactList[] = new contact ($contact);
        }
        return $contactList;
    }

    // Foncction pour récupérer un contact à partir d'une seule donnée
    public function extractResearchContact($donneeRecherchee, $valeurRecherchee) {

        $sql = 'SELECT * FROM contacts WHERE ' . $donneeRecherchee . ' = :value';

        // Appel du dbManager pour exécuter la requête
        $contactData = $this->db->query($sql, [
            'value' => $valeurRecherchee,
        ]);
        // Récupérer une seule ligne
        $contactData = $contactData->fetch(PDO::FETCH_ASSOC);
    
        // Vérifier si un résultat est trouvé
        if ($contactData) {
            $contact = new Contact();
            $contact->setIdContact($contactData['idContact']);
            $contact->setNom($contactData['nom']);
            $contact->setContact($contactData['contact']);
            $contact->setSiren($contactData['siren']);
            $contact->setEmail($contactData['email']);
            $contact->setTelephone($contactData['telephone']);
            $contact->setSiteInternet($contactData['siteInternet']);
            $contact->setSens($contactData['sens']);
    
            return $contact;
        }
    
        return null;
    }

    public function getContactByIdContact($idContact) {
        if (empty($idContact)) {
            return null; // Retourne null si aucun ID n'est fourni
        }
    
        $sql = "SELECT * FROM contacts WHERE idContact = " . (int) $idContact;
        
        // Exécution de la requête
        $result = $this->db->query($sql);
        
        // Récupérer un seul résultat
        $row = $result->fetch(PDO::FETCH_ASSOC);
    
        // Création et hydratation de l'objet Contact
        $contact = new Contact();
        $contact->setIdContact($row['idContact']);
        $contact->setNom($row['nom']);
        $contact->setContact($row['contact']);
        $contact->setSiren($row['siren']);
        $contact->setEmail($row['email']);
        $contact->setTelephone($row['telephone']);
        $contact->setSiteInternet($row['siteInternet']);
        $contact->setSens($row['sens']);
    
        return $contact;
    }

    public function getContactsByIdsContact(array $idsContacts) {
        if (empty($idsContacts)) {
            return []; // Retourne un tableau vide si aucun ID n'est fourni
        }
    
        // Création des placeholders pour la requête SQL (ex: :id0, :id1, ...)
        $placeholders = implode(',', array_map(fn($key) => ":id$key", array_keys($idsContacts)));
    
        // Requête SQL avec IN et des paramètres sécurisés
        $sql = "SELECT * FROM contacts WHERE idContact IN ($placeholders)";
    
        // Associer les valeurs aux placeholders
        $params = [];
        foreach ($idsContacts as $key => $id) {
            $params[":id$key"] = $id;
        }
    
        // Exécuter la requête
        $result = $this->db->query($sql, $params);
        $rows = $result->fetchAll(PDO::FETCH_ASSOC);
    
        // Convertir chaque ligne en objet Contact
        $contacts = [];
        foreach ($rows as $row) {
            $contact = new Contact();
            $contact->setIdContact($row['idContact']);
            $contact->setNom($row['nom']);
            $contact->setContact($row['contact']);
            $contact->setEmail($row['email']);
            $contact->setTelephone($row['telephone']);
    
            $contacts[] = $contact;
        }
    
        return $contacts;
    }

    public function getVendeurs(): array {
        $sql = "SELECT idContact FROM contacts WHERE sens = 'vendeur'";
        $result = $this->db->query($sql);
    
        if (!$result) {
            throw new Exception("Erreur lors de la récupération des vendeurs.");
        }
        
        $contactList = [];
        while ($contact = $result->fetch(PDO::FETCH_ASSOC)) {
            $contactList[] = new Contact($contact);
        }
        return $contactList;
    }

    public function verifierEtMettreAJourContact($idContact, $champ, $nouvelleValeur) {
        // Vérifier si la donnée existe déjà pour ce contact
        $sql = "SELECT $champ FROM contacts WHERE idContact = :idContact";
        $contactActuel = $this->db->query($sql, [$idContact])->fetch(PDO::FETCH_ASSOC);
    
        if (!$contactActuel) {
            return ["status" => "error", "message" => "Contact introuvable."];
        }
    
        $valeurExistante = $contactActuel[$champ];
    
        // Si la valeur est identique, ne rien faire
        if ($valeurExistante === $nouvelleValeur) {
            return ["status" => "no_change", "message" => "Aucune modification nécessaire."];
        }
    
        // Si le champ est vide, mettre à jour directement
        if (empty($valeurExistante)) {
            $this->mettreAJourContact($idContact, $champ, $nouvelleValeur);
            return ["status" => "success", "message" => "Donnée mise à jour avec succès."];
        }
    
        // Si une modification est nécessaire, demander confirmation
        return [
            "status" => "confirm_required",
            "message" => "Une modification est détectée, confirmation requise.",
            "champ" => $champ,
            "ancien" => $valeurExistante,
            "nouveau" => $nouvelleValeur,
            "idContact" => $idContact
        ];
    }   

    public function mettreAJourContact($idContact, $champ, $valeur) {
        // Mise à jour du contact
        $sql = "UPDATE contacts SET $champ = ? WHERE idContact = ?";
        $this->db->query($sql, [$valeur, $idContact]);
    
        // Vérifier si la valeur est "vendeur"
        if ($champ === "sens" && strtolower($valeur) === "vendeur") {
            // Vérifier si le contact est déjà un client
            $checkSql = "SELECT COUNT(*) as count FROM clients WHERE idContact = ?";
            $stmt = $this->db->query($checkSql, [$idContact]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC); // Utilisation de fetch() au lieu de row()
    
            if ($result['count'] == 0) {
                // Insérer dans la table clients avec statut "Approche" et dateStatut = NOW()
                $insertSql = "INSERT INTO clients (idContact, statut, dateStatut) VALUES (?, ?, NOW())";
                $this->db->query($insertSql, [$idContact, "Approche"]);
            }
        }
    
        return ["status" => "success", "message" => "Modification effectuée."];
    }   

    public function getIdContactByEmail($email){
            $sql = "SELECT idContact FROM contacts WHERE email = '$email'";
            $result =  $this->db->query($sql)->fetchColumn();

            return $result;
        }
        

    }
