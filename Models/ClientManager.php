<?php

include_once('AbstractEntityManager.php');

class ClientManager extends AbstractEntityManager {
    
    public function insertClient($idContact, $statut, $valorisation, $commission) {
            $sql = 'INSERT INTO clients (idContact, statut, valorisation, commission) 
                    VALUES (:idContact, :statut, :valorisation, :commission)';
            $this->db->query($sql, [
                'idContact' => $idContact,
                'statut' => $statut,
                'valorisation' => $valorisation,
                'commission' => $commission
            ]);
        }

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
        
}