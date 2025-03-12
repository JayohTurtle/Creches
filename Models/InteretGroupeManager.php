<?php

include_once('AbstractEntityManager.php');

class InteretGroupeManager extends AbstractEntityManager{
    public $db;

    public function getIdGroupeByName($nom){
        $sql = "SELECT i.niveau, i.idContact, i.date_colonne AS dateInteret
        FROM interetgroupe i
        WHERE i.nom = :nom";

        $query = $this->db->query($sql, ['nom' => $nom]);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $interetsGroupe = [];
            foreach ($result as $row) {
                $interetsGroupe[] = new InteretGroupe($row);
            }

        return $interetsGroupe;

    }

    public function getContactsByGroupe($groupe)
    {
        $sql = 'SELECT 
                g.*,
                c.idContact,
                c.contact,
                c.nom, 
                c.telephone, 
                c.email, 
                i.niveau
            FROM groupes g
            JOIN contacts c ON i.idContact = c.idContact
            JOIN interetGroupe ig ON g.idGroupe = ig.idGroupe
            WHERE g.groupe = :groupe';

        $stmt = $this->db->query($sql, [':groupe' => $groupe]);

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
    
    public function insertInteretGroupe(InteretGroupe $interetGroupe) {
        // Récupérer les valeurs à partir de l'objet InteretGroupe
        $niveau = $interetGroupe->getNiveau();
        $idContact = $interetGroupe->getIdContact();
        $idGroupe= $interetGroupe->getIdGroupe();
        
        // Vérifier si le niveau est vide ou null
        if ($niveau === "" || $niveau === null) {
            return;
        }
        
        // Requête SQL pour insertion ou mise à jour
        $sql = 'INSERT INTO interetgroupe (idGroupe, idContact, niveau) 
                VALUES (:idGroupe, :idContact, :niveau)
                ON DUPLICATE KEY UPDATE 
                    niveau = VALUES(niveau), 
                    date_colonne = IF(date_colonne IS NOT NULL, NOW(), date_colonne)';

        // Passer directement la requête à ton dbManager
        $result = $this->db->query($sql, [
            'idGroupe'=> $idGroupe,
            'idContact'=> $idContact,
            'niveau'=> $niveau,
            
        ]);
        return $result;
    }

    public function getInteretsGroupesByIdContact($idContact) {

        $sql = "SELECT i.niveau,i.idGroupe, i.date_colonne AS dateInteret,
                g.groupe
                FROM interetgroupe i
                JOIN groupes g ON i.idGroupe = g.idGroupe
                JOIN contacts c ON i.idContact = c.idContact
                WHERE i.idContact = :idContact";
   
       $query = $this->db->query($sql, ['idContact' => $idContact]);
       $result = $query->fetchAll(PDO::FETCH_ASSOC);
       
       if(!$result){
           return null;
       }

       $interetsGroupes = [];
        foreach ($result as $row) {
        $interetGroupe = new InteretGroupe($row);
        $interetGroupe->setGroupe($row['groupe']); // Ajout de la valeur du groupe
        $interetsGroupes[] = $interetGroupe;
        }

        return ($interetsGroupes);
   }

   public function getInteretsGroupeByIdGroupe($idGroupe) {

    if (empty($idGroupe)) {
        return null;
    }

    $sql = "SELECT 
            ig.*,
            g.groupe, g.idContact AS idClient,
            c.contact, c.nom, c.telephone, c.email
        FROM interetGroupe ig
        JOIN groupes g ON ig.idGroupe = g.idGroupe
        JOIN contacts c ON ig.idContact = c.idContact
        WHERE ig.idGroupe = :idGroupe ;
    ";
    
    $result = $this->db->query($sql,['idGroupe' => $idGroupe]);
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);
    
    $interetsGroupe = [];
    foreach ($rows as $row) {
        $interetGroupe = new InteretGroupe([
            'idAcheteur' => $row['idContact'],
            'niveau' => $row['niveau'],
            'dateInteret' => $row['date_colonne'],
            'contact' => new Contact([
                'idContact' => $row['idContact'],
                'contact' => $row['contact'],
                'nom' => $row['nom'],
                'email' => $row['email'],
                'telephone' => $row['telephone']
            ])
        ]);
    
        $interetsGroupe[] = $interetGroupe;
    }
    
    return $interetsGroupe;
}

}