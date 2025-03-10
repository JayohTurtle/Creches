<?php

class clientsController {

    private $clientManager;
    private $localisationManager;
    private $contactManager;
    private $villeManager;
    private $departementManager;
    private $regionManager;
    
    public function __construct() {
        $this->clientManager = new ClientManager();
        $this->localisationManager = new LocalisationManager();
        $this->contactManager = new ContactManager();
        $this->villeManager = new VilleManager();
        $this->departementManager = new DepartementManager();
        $this->regionManager = new RegionManager();

    }

    public function showclients() {
        // Récupérer les données des clients
        $clientsData = $this->clientManager->getDataClients();

        $clients = [];  // Tableau pour stocker les clients avec leurs informations
        $localisationsAVendre = [];  // Tableau pour stocker les localisations à vendre

        foreach ($clientsData as $client) {
            // Récupérer l'idContact pour chaque client
            $idContact = $client->getIdContact();
            
            // Récupérer les informations du client associées à cet idContact
            $contact = $this->contactManager->getContactById($idContact);  // Méthode qui récupère les informations du client depuis la table contacts
            
            // Ajouter les données du client dans le tableau clientsData
            $clients[$idContact] = $contact;  // Stocke l'objet Contact sous la clé idContact
            
            // Récupérer les localisations à vendre pour cet idContact
            $localisationsVendeurs = $this->localisationManager->getLocalisationsAVendre($idContact);

            // Ajouter les localisations à vendre dans le tableau localisationsAVendre
            foreach ($localisationsVendeurs as $localisationData) {
                $identifiant = $localisationData->getIdentifiant();
                
                // Ajouter l'identifiant au tableau $localisationsAVendre sous la clé correspondant à idContact
                $localisationsAVendre[$idContact][] = $identifiant;
            }
        }

        $identifiants = [];  // Tableau pour stocker tous les identifiants
        foreach ($localisationsAVendre as $localisationArray) {
            foreach ($localisationArray as $localisation) {
                // Ajouter chaque identifiant au tableau
                $identifiants[] = $localisation;
            }
        }

        $villes = $this->villeManager->getVilles();
        $departements = $this->departementManager->getDepartements();
        $regions = $this->regionManager->getRegions();

        // S'assurer de la correspondance des statuts
        $statutMapping = [
            "Mandat signé" => "mandats_signes",
            "Mandat envoyé" => "mandats_envoyes",
            "Négociation" => "negociation",
            "Approche" => "approche",
            "Sous offre" => "sous_offre",
            "Vendu" => "vendu"
        ];

        $clientsByStatut = [
            "mandats_signes" => ["nbCreches" => 0, "totalCommission" => 0, "clients" => []],
            "mandats_envoyes" => ["nbCreches" => 0, "totalCommission" => 0, "clients" => []],
            "negociation" => ["nbCreches" => 0, "totalCommission" => 0, "clients" => []],
            "approche" => ["nbCreches" => 0, "totalCommission" => 0, "clients" => []],
            "sous_offre" => ["nbCreches" => 0, "totalCommission" => 0, "clients" => []],
            "vendu" => ["nbCreches" => 0, "totalCommission" => 0, "clients" => []]
        ];
        
        // Tableau pour stocker les idContacts par statut
        $clientsByStatutContacts = [
            "mandats_signes" => [],
            "mandats_envoyes" => [],
            "negociation" => [],
            "approche" => [],
            "sous_offre" => [],
            "vendu" => []
        ];
    
        // Trier les clients par statut
        foreach ($clientsData as $client) {
            $statut = $client->getStatut();  // Récupérer le statut du client
        
            // Mapper le statut du client au statut correct
            if (isset($statutMapping[$statut])) {
                $statutCorrect = $statutMapping[$statut];
                
                // Ajouter le client au bon groupe
                $clientsByStatut[$statutCorrect]['clients'][] = $client;
                $clientsByStatutContacts[$statutCorrect][] = $client->getIdContact();  // Ajouter l'idContact
                
                // Ajouter la commission
                $clientsByStatut[$statutCorrect]['totalCommission'] += $client->getCommission(); 
            }
        }
        
        // Utiliser countCrechesAVendre pour obtenir le nombre total de crèches pour chaque statut
        foreach ($clientsByStatutContacts as $statut => $idContacts) {
            // Appel de la fonction countCrechesAVendre en passant les idContacts pour chaque statut
            $nbCreches = $this->localisationManager->countCrechesAVendre($idContacts);
            
            // Mettre à jour nbCreches pour chaque statut
            $clientsByStatut[$statut]['nbCreches'] = $nbCreches;
        }

        // Initialiser un nouveau statut "Tous"
        $totalClients = [];
        $totalNbCreches = 0;
        $totalCommission = 0;

        // Parcourir tous les statuts pour agréger les données
        foreach ($clientsByStatut as $statut => $data) {
            if (!empty($data['clients'])) {
                $totalClients = array_merge($totalClients, $data['clients']);
                $totalNbCreches += $data['nbCreches'];
                $totalCommission += $data['totalCommission'];
            }
        }

        // Ajouter le statut "Tous" avec les données agrégées
        $clientsByStatut['tous'] = [
            'clients' => $totalClients,
            'nbCreches' => $totalNbCreches,
            'totalCommission' => $totalCommission
        ];

          // Vérifier si le statut "tous" existe
        if (isset($clientsByStatut['tous'])) {
            // Extraire le statut "tous"
            $statutTous = ['tous' => $clientsByStatut['tous']];
            
            // Supprimer "tous" du tableau original
            unset($clientsByStatut['tous']);
            
            // Fusionner "tous" au début du tableau réorganisé
            $clientsByStatut = $statutTous + $clientsByStatut;
        }

        // Passer les données à la vue
        $view = new View();
        $view->render("clients", [
            'localisationsAVendre' => $localisationsAVendre,
            'identifiants' => $identifiants,
            'clients' => $clients,
            'clientsByStatut' => $clientsByStatut,
            'clientsData' => $clientsData,
            'statutMapping' => $statutMapping,
            'villes' => $villes,
            'departements' => $departements,
            'regions' => $regions
        ]);
    }
    
}
    
    