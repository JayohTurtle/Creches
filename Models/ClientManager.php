<?php

include_once('AbstractEntityManager.php');

class ClientManager extends AbstractEntityManager {

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

    //Fonction pour récupérer les données des vendeurs
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

    // on récupère les données dans clients avec idContact
    public function getDataClientsByIdContact($idContact){

        $sql = "SELECT commission, valorisation, statut, dateStatut, idClient
        FROM clients
        WHERE idContact = ?";

        $result = $this->db->query($sql, [$idContact]);

        if ($result->rowCount() > 0) {
            $row = $result->fetch();

            $clientData = new Client();
            $clientData ->setIdClient($row['idClient']);
            $clientData->setValorisation($row['valorisation']);
            $clientData->setCommission($row['commission']);
            $clientData->setStatut($row['statut']);
            $clientData->setDateStatut($row['dateStatut']);

            return $clientData;
        }
        return null;
    }

    public function getClientsByStatut($statut){

        $statutMapping = [
            'approche' => 'Approche',
            'negociation' => 'Négociation',
            'mandats_envoyes' => 'Mandat envoyé',
            'mandats_signes' => 'Mandat signé',
            'vendu' => 'Vendu'
        ];

        if (isset($statutMapping[$statut])) {
            $statutEnBase = $statutMapping[$statut];
        } else {
            $statutEnBase = null; // Par défaut, si la valeur n'existe pas
        }
    
        // Si on veut tous les statuts, on ne met pas de filtre WHERE
        if ($statut === "Tous") {
            $sql = "SELECT cl.idContact, cl.idClient, cl.statut, cl.valorisation, cl.commission, cl.dateStatut,
                        c.contact, c.nom, c.email, c.telephone
                    FROM clients cl
                    JOIN contacts c ON cl.idContact = c.idContact";
            $query = $this->db->query($sql);
        } else {
            $sql = "SELECT cl.idContact, cl.idClient, cl.statut, cl.valorisation, cl.commission, cl.dateStatut,
                        c.contact, c.nom, c.email, c.telephone
                    FROM clients cl
                    JOIN contacts c ON cl.idContact = c.idContact
                    WHERE cl.statut = :statut";
            $query = $this->db->query($sql, ['statut' => $statutEnBase]);
        }

        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $clients = [];
        foreach ($result as $row) {
            // Création des objets clients
            $client = new Client([
                'idContact'=> $row['idContact'],
                'idClient'=> $row['idClient'],
                'statut'=> $row['statut'],
                'valorisation'=> $row['valorisation'],
                'commission'=> $row['commission'],
                'dateStatut'=> $row['dateStatut'],
            ]);

            $contact = new Contact([
                'contact' => $row['contact'],
                'nom' => $row['nom'],
                'email'=> $row['email'],
                'telephone'=> $row['telephone']
            ]);

            $client->setContact($contact);
            $clients[] = $client;
        }

        return $clients;
    }

    public function getCommissions() {
        $sql = "SELECT SUM(commission) AS total_commission FROM clients WHERE statut = 'Vendu'";
        $result = $this->db->query($sql)->fetch(PDO::FETCH_ASSOC);
    
        return $result['total_commission'] ?? 0; // Retourne la somme ou 0 si null
    }    

    public function modifCommission($idContact, $commission) {
        $sql = "UPDATE clients SET commission = '$commission' WHERE idContact = $idContact";
        return $this->db->query($sql);
    }

    public function modifValorisation($idContact, $valorisation) {
        $sql = "UPDATE clients SET valorisation = '$valorisation' WHERE idContact = $idContact";
        return $this->db->query($sql);
    }

    public function modifStatut($idContact, $statut){
        $sql = "UPDATE clients SET statut = '$statut' WHERE idContact = $idContact";
        return $this->db->query($sql);
    }
}