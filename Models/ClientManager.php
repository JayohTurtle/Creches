<?php

include_once('AbstractEntityManager.php');

class ClientManager extends AbstractEntityManager {
    
    //on récupère le nom dans la base contacts et les identifiants dans la base localisations
    //les identifiants sont récupérés sous forme de tableau
    public function getClientsWithContacts() {
        $sql = "SELECT clients.*, 
                        contacts.nom AS nom, 
                        GROUP_CONCAT(DISTINCT localisations.identifiant SEPARATOR ', ') AS identifiants
                FROM clients
                JOIN contacts ON clients.idContact = contacts.idContact
                LEFT JOIN localisations ON contacts.idContact = localisations.idContact
                GROUP BY clients.idClient, contacts.nom";
        
        $statement = $this->db->query($sql);
        $clientList = [];
    
        while ($row = $statement->fetch()) {
            $client = new Client($row);
            $client->setNom($row['nom']); // Stocker le nom du contact
            $client->setIdentifiant($row['identifiants'] ?? ''); // Stocker les identifiants concaténés
            $clientList[] = $client;
        }
    
        return $clientList;
    }

    public function getDataClients(){
        $sql = "SELECT idContact, commission, statut, dateStatut FROM clients";
        $result = $this->db->query($sql);
        $clientsData = [];
    
        while ($row = $result->fetch()) {
            $client = new Client(); // Création d'un objet Client
            $client->setIdContact($row['idContact']);
            $client->setCommission($row['commission']);
            $client->setDateStatut($row['dateStatut']);
            $client->setStatut($row['statut']);
    
            $clientsData[] = $client;
        }
    
        return $clientsData; // Retourne un tableau d'objets Client
    }

    public function getAllClients() {
        // Requête SQL pour récupérer tous les clients
        $sql = 'SELECT * FROM clients';
        
        // Appel du dbManager pour exécuter la requête
        $clientsData = $this->db->query($sql);
        
        // Créer des objets Client à partir des données
        $clients = [];
        foreach ($clientsData as $clientData) {
            $client = new Client();
            $client->setIdContact($clientData['idContact']);
            $client->setIdClient($clientData['idClient']);
            $client->setStatut($clientData['statut']);
            $client->setDateStatut($clientData['dateStatut']);
            $client->setCommission($clientData['commission']);
            $client->setValorisation($clientData['valorisation']);
            // Ajoute d'autres attributs si nécessaire
            $clients[] = $client;
        }
        
        return $clients; // Retourne un tableau d'objets Client
    }

    public function getIdClients(){
        $sql = "SELECT idContact FROM clients";
        $idClients = $this->db->query($sql);
        return $idClients->fetchAll(PDO::FETCH_ASSOC); // Récupérer les résultats sous forme de tableau associatif
    }
    
    public function insertClient(Client $client) {
        $sql = 'INSERT INTO clients (idContact, statut, valorisation, commission) 
                VALUES (:idContact, :statut, :valorisation, :commission)';
        
        $this->db->query($sql, [
            'idContact' => $client->getIdContact(),
            'statut' => $client->getStatut(),
            'valorisation' => $client->getValorisation(),
            'commission' => $client->getCommission()
        ]);
    }
    
    // on récupère les données dans clients avec idContact
    public function getDataClientsById($idContact){

        $sql = "SELECT commission, valorisation, statut, dateStatut
        FROM clients
        WHERE idContact = ?";

        $result = $this->db->query($sql, [$idContact]);

        if ($result->rowCount() > 0) {
            $row = $result->fetch();

            $clientData = new Client();
            $clientData->setValorisation($row['valorisation']);
            $clientData->setCommission($row['commission']);
            $clientData->setStatut($row['statut']);
            $clientData->setDateStatut($row['dateStatut']);

            return $clientData;
        }
        return null;
    }
        
}