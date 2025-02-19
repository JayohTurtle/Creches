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
                   OR (contact = :contact AND email = :email) 
                LIMIT 1';
    
        $query = $this->db->query($sql, [
            'nom' => $nom,
            'contact' => $contact,
            'email' => $email
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
        $statement = $this -> db -> query($request);

        $contactList=[];
        while ($contact = $statement -> fetch()){
            $contactList[] = new contact ($contact);
        }
        return $contactList;
    }

    
    
    public function getContactById($id) {
        $sql = 'SELECT * FROM contacts WHERE id = :id';
        $result = $this->db->query($sql, ['id' => $id]);
    
        if ($result->rowCount() > 0) {
            $row = $result->fetch();
    
            $contact = new Contact();
            $contact->setIdContact($row['id']);
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

    // Liste des colonnes autorisées pour éviter l'injection SQL
    private $allowedColumns = ['contact', 'nom', 'email', 'telephone', 'siren', 'siteInternet'];

    // Extrait les résultats sous forme d'objets ResearchContact
    public function extractResearchContact($donneeRecherchee, $valeurRecherchee) {
        // Vérifier si la colonne demandée est autorisée
        if (!in_array($donneeRecherchee, $this->allowedColumns)) {
            throw new Exception("Colonne non autorisée");
        }
    
        // Requête SQL sécurisée avec LIKE
        $sql = 'SELECT * FROM contacts WHERE ' . $donneeRecherchee . ' LIKE :value';
        $statement = $this->db->prepare($sql);
        $statement->execute(['value' => "%$valeurRecherchee%"]);
    
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

    public function getVendeurContactsByIdContacts(array $idContacts): array
{
    if (empty($idContacts)) {
        return []; // Aucun contact trouvé
    }

    // Création des placeholders pour la requête SQL
    $placeholders = implode(',', array_fill(0, count($idContacts), '?'));

    $sql = "SELECT * FROM contacts WHERE idContact IN ($placeholders) AND sens = 'vendeur'";
    
    // Exécuter la requête avec les IDs en paramètre
    $stmt = $this->db->query($sql, $idContacts);

    // Stocker les résultats sous forme d'objets Contact
    $vendeurs = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $vendeurs[] = new Contact($row);
    }

    return $vendeurs;
}
}


