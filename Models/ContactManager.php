<?php

include_once('AbstractEntityManager.php');

class ContactManager extends AbstractEntityManager {
    public $db;

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
    
    
    // Ajouter un commentaire
    public function insertComment($nom, $contact, $comment, $dateJour) {
        $sql = 'INSERT INTO commentaires(nom, contact, commentaire, date_comment) VALUES (:nom, :contact, :commentaire, :date_comment)';
        $this->db->query($sql, [
            'nom' => $nom,
            'contact' => $contact,
            'commentaire' => $comment,
            'date_comment' => $dateJour,
        ]);
    }

    // Ajouter un contact en base
    public function insertContact($nom, $contact, $siren, $email, $telephone, $siteInternet, $sens) {
        $sql = 'INSERT INTO contacts(nom, contact, siren, email, telephone, siteInternet, sens) 
                VALUES (:nom, :contact, :siren, :email, :telephone, :siteInternet, :sens)';
        $this->db->query($sql, [
            'nom' => $nom,
            'contact' => $contact,
            'siren' => $siren,
            'email' => $email,
            'telephone' => $telephone,
            'siteInternet' => $siteInternet,
            'sens' => $sens
        ]);
        return $this->db->lastInsertId();
    }

    function getContacts(){
        $request = "select * from contacts";
        $result = $this -> db -> query($request);

        $contactList=[];
        while ($contact = $result -> fetch()){
            $contactList[] = new contact ($contact);
        }
        return $contactList;
    }

    public function getContactById($id) {
        $sql = 'SELECT * FROM contacts WHERE idContact = :id';
        $result = $this->db->query($sql, ['id' => $id]);
    
        if ($result->rowCount() > 0) {
            $row = $result->fetch();
    
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

    //Récupére l'id d'un nom de groupe
    public function getIdContactByName($nom) {
        $sql = "SELECT idContact FROM contacts WHERE nom = :nom LIMIT 1";
        $stmt = $this->db->prepare($sql);  // Prépare la requête SQL
        $stmt->execute(['nom' => $nom]);  // Exécute avec la valeur de l'identifiant
        return $stmt->fetchColumn();  // Retourne l'ID du contact
    }

    // Extrait les résultats sous forme d'objets ResearchContact
    public function extractResearchContact($donneeRecherchee, $valeurRecherchee) {
        // Requête SQL sécurisée avec LIKE
        $sql = 'SELECT * FROM contacts WHERE ' . $donneeRecherchee . ' = :value';
        $statement = $this->db->prepare($sql);
        $statement->execute(['value' => "$valeurRecherchee"]);
    
        // Récupérer une seule ligne
        $contactData = $statement->fetch(PDO::FETCH_ASSOC);
    
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
    
            return $contact; // ✅ Retourne un seul objet ResearchContact
        }
    
        return null; // ❌ Retourne null si aucun résultat trouvé
    }

    // Extrait les résultats sous forme d'objets ResearchClient
    public function extractResearchClient($donneeRecherchee, $valeurRecherchee) {
        // Requête SQL sécurisée avec LIKE et filtrage sur 'sens'
        $sql = 'SELECT idContact, nom, contact, siren, email, telephone, siteInternet, sens 
                FROM contacts 
                WHERE ' . $donneeRecherchee . ' = :value 
                AND sens = :sens';
    
        // Appel du dbManager pour exécuter la requête
        $contactData = $this->db->executeQuery($sql, [
            'value' => $valeurRecherchee,
            'sens' => 'Vendeur' // Filtrer par "Vendeur"
        ]);
    
        // Vérifier si un contact est trouvé
        if ($contactData) {
            $contactData = $contactData[0]; // On prend le premier (et unique) résultat
    
            $contact = new Contact();
            $contact->setIdContact($contactData['idContact']);
            $contact->setNom($contactData['nom']);
            $contact->setContact($contactData['contact']);
            $contact->setSiren($contactData['siren']);
            $contact->setEmail($contactData['email']);
            $contact->setTelephone($contactData['telephone']);
            $contact->setSiteInternet($contactData['siteInternet']);
            $contact->setSens($contactData['sens']);
    
            return $contact; // Retourne l'objet Contact unique
        }
    
        return null; // Retourne null si aucun résultat n'est trouvé
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
    
    function comparerContacts($localisationContacts,$idVendeurs) {

        // Étape 1 : Filtrer les localisations en fonction des vendeurs
        $filteredLocalisations = array_filter($localisationContacts, function ($localisation) use ($idVendeurs) {
            return in_array($localisation['idContact'], $idVendeurs);
        });

        // Étape 2 : Transformer le tableau filtré en objets
        $localisations = [];
        foreach ($filteredLocalisations as $localisation) {
            $loc = new Localisation(); // Créer une nouvelle instance de Localisation
            $loc->setIdentifiant($localisation['identifiant']);
            $loc->setIdLocalisation($localisation['idLocalisation']);
            $loc->setDistance($localisation['distance_km']);

        
            $localisations[] = $loc; // Ajouter l'objet Localisation au tableau
        }
       
        return $localisations;
    }
    
}
    
    



