<?php

include_once('AbstractEntityManager.php');

class ContactManager extends AbstractEntityManager {
 
    public function __construct() {
        $this->db = DBManager::getInstance();
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
            'email2'=> $email
        ]);
    
        $idContact = (int) $query->fetchColumn(); // Récupère directement l'ID s'il existe et force le int
    
        return $idContact ?: null; // Retourne l'ID s'il existe, sinon null
    }  

    //Récupére l'id d'un nom de groupe
    public function getIdContactByName($nom) {
        $sql = "SELECT idContact FROM contacts WHERE nom = :nom LIMIT 1";
        $stmt = $this->db->prepare($sql);  // Prépare la requête SQL
        $stmt->execute(['nom' => $nom]);  // Exécute avec la valeur de l'identifiant
        return $stmt->fetchColumn();  // Retourne l'ID du contact
    }

    //Récupère le nom d'un groupe
    public function getNamesByIdContacts($idContacts) {
        // Vérifier que $idContacts est bien un tableau d'IDs
        if (is_array($idContacts) && count($idContacts) > 0) {
            // Implode pour transformer l'array en une chaîne séparée par des virgules
            $idContactsStr = implode(',', $idContacts);
            
            // Ta requête SQL avec la clause IN
            $sql = "SELECT nom FROM contacts WHERE idContact IN ($idContactsStr)";

            // Exécuter la requête et récupérer les résultats
            $stmt = $this->db->query($sql);
            
            // Récupérer les résultats sous forme de tableau associatif
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            return []; // Si l'argument n'est pas un tableau ou est vide, retourne un tableau vide
        }
    }
 
    // Extrait les résultats sous forme d'objets ResearchClient
    public function extractResearchClient($donneeRecherchee, $valeurRecherchee) {
        // Requête SQL sécurisée avec LIKE et filtrage sur 'sens'
        $sql = 'SELECT idContact, nom, contact, siren, email, telephone, siteInternet, sens 
                FROM contacts 
                WHERE ' . $donneeRecherchee . ' = :value 
                AND sens = :sens';
    
        // Appel du dbManager pour exécuter la requête
        $contactData = $this->db->query($sql, [
            'value' => $valeurRecherchee,
            'sens' => 'Vendeur' // Filtrer par "Vendeur"
        ]);
    
        // Vérifier si un contact est trouvé
        if ($contactData) {
            // Utiliser fetch pour obtenir le premier (et unique) résultat sous forme de tableau associatif
            $contactData = $contactData->fetch(PDO::FETCH_ASSOC); // Récupérer les données sous forme de tableau associatif
    
            if ($contactData) {
                // Créer un nouvel objet Contact et remplir ses propriétés
                $contact = new Contact();
                $contact->setIdContact($contactData['idContact']);
                $contact->setNom($contactData['nom']);
                $contact->setContact($contactData['contact']);
                $contact->setSiren($contactData['siren']);
                $contact->setEmail($contactData['email']);
                $contact->setTelephone($contactData['telephone']);
                $contact->setSiteInternet($contactData['siteInternet']);
                $contact->setSens($contactData['sens']);
    
                return $contact; // Retourne l'objet Contact
            } else {
                // Aucun résultat trouvé
                return null;
            }
        }
    
        // Si la requête échoue ou n'a pas retourné de données
        return null;
    }
    
    public function getVendeurs(): array {
        $sql = "SELECT idContact FROM contacts WHERE sens = 'vendeur'";
        $result = $this->db->query($sql);
    
        if (!$result) {
            throw new Exception("Erreur lors de la récupération des vendeurs.");
        }
        
        $contactList = [];
        while ($contact = $result->fetch(PDO::FETCH_ASSOC)) {
            $contactList[] = new Contact($contact); // ✅ Hydratation automatique via AbstractEntity
        }
        return $contactList;
    }

    
    
    public function updateContact($idContact, $infosContact) {
        // Récupérer les données actuelles du contact
        $sql = "SELECT nom, contact, siren, telephone, email, sens, siteInternet 
                FROM contacts WHERE idContact = ?";
        $contactActuel = $this->db->query($sql, [$idContact])->fetch(PDO::FETCH_ASSOC);
        
        if (!$contactActuel) {
            return ["status" => "error", "message" => "Contact introuvable."];
        }
    
        // Comparer les anciennes et nouvelles valeurs
        $champsAChanger = [];
        foreach ($infosContact as $colonneBDD => $valeur) {
            $ancienneValeur = $contactActuel[$colonneBDD] ?? ""; // Gérer les NULL
            if ($ancienneValeur !== $valeur) {
                $champsAChanger[$colonneBDD] = [
                    'ancien' => $ancienneValeur,
                    'nouveau' => $valeur
                ];
            }
        }
    
        if (empty($champsAChanger)) {
            return ["status" => "no_change", "message" => "Aucune modification nécessaire."];
        }
    
        return [
            "status" => "success",
            "modifications" => $champsAChanger,
            "contactActuel" => $contactActuel // 🔥 On passe les données actuelles pour éviter une requête en double
        ];
    }
    
    public function confirmerUpdateContact($idContact, $infosContact, $contactActuel = null) {
        // Vérification et récupération de idContact si nécessaire
        if (empty($idContact)) {
            if (!isset($_POST["idContact"])) {
                $donnees = json_decode(file_get_contents("php://input"), true);
                if (is_array($donnees) && isset($donnees["idContact"])) {
                    $_POST["idContact"] = $donnees["idContact"];
                }
            }
            $idContact = $_POST["idContact"] ?? null;
        }
    
        // Vérifier si le contact existe déjà
        if ($contactActuel === null) {
            $sql = "SELECT nom, contact, siren, telephone, email, sens, siteInternet 
                    FROM contacts WHERE idContact = ?";
            $contactActuel = $this->db->query($sql, [$idContact])->fetch(PDO::FETCH_ASSOC);
        }
    
        if (!$contactActuel) {
            return ["status" => "error", "message" => "Contact introuvable."];
        }
    
        // 🛠 Déterminer les champs à mettre à jour
        $champsAChanger = [];
        foreach ($infosContact as $champBdd => $valeur) {
            if (!isset($contactActuel[$champBdd])) {
                error_log("🚨 ERREUR - Clé '$champBdd' absente du contact actuel !");
                continue;
            }
            
            if ($contactActuel[$champBdd] !== $valeur) {
                $champsAChanger[$champBdd] = $valeur;
            }
        }
    
        // 🔄 Effectuer la mise à jour si nécessaire
        if (!empty($champsAChanger)) {
            $setParts = [];
            $values = [];
    
            foreach ($champsAChanger as $champBdd => $valeur) {
                $setParts[] = "$champBdd = ?";
                $values[] = $valeur;
            }
    
            $values[] = $idContact;
            $sqlUpdate = "UPDATE contacts SET " . implode(", ", $setParts) . " WHERE idContact = ?";
            $stmt = $this->db->prepare($sqlUpdate);
            $stmt->execute($values);
        }
    
        return ["status" => "success", "message" => "Mise à jour effectuée avec succès."];
    }
    

    // Ajouter un contact en base
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

    // Extrait les résultats sous forme d'objets ResearchContact
    public function extractResearchContact($donneeRecherchee, $valeurRecherchee) {
        // Requête SQL sécurisée avec LIKE
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
    
    function getAcheteursContacts(){
        $request = "SELECT * FROM contacts WHERE sens = 'acheteur'";
        $result = $this -> db -> query($request);

        $contactList=[];
        while ($contact = $result -> fetch()){
            $contactList[] = new contact ($contact);
        }
        return $contactList;
    }

    function getVendeursContacts(){
        $request = "SELECT * FROM contacts WHERE sens = 'vendeur'";
        $result = $this -> db -> query($request);

        $contactList=[];
        while ($contact = $result -> fetch()){
            $contactList[] = new contact ($contact);
        }
        return $contactList;
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

    public function getAcheteursById($idContact) {
        // Requête SQL avec toutes les colonnes nécessaires
        $sql = "SELECT idContact, nom, contact, siren, email, telephone, siteInternet, sens 
                FROM contacts 
                WHERE sens = 'acheteur' AND idContact = :idContact";
        
        // Exécution de la requête via DBManager
        $result = $this->db->query($sql, ['idContact' => $idContact]);
    
        if ($row = $result->fetch(PDO::FETCH_ASSOC)) {
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
        
        return null;
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

    public function getContactById($idContact) {
        if (empty($idContact)) {
            return null; // Retourne null si aucun ID n'est fourni
        }
    
        // Requête SQL avec un paramètre sécurisé
        $sql = "SELECT * FROM contacts WHERE idContact = :idContact";
        
        // Préparation et exécution de la requête
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['idContact' => (int) $idContact]);
    
        // Récupérer un seul résultat
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$row) {
            return null; // Retourne null si aucun contact trouvé
        }
    
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

    
}
    
    



