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
    
}


