<?php

class ContactFormController {
    private $villeManager;
    private $departementManager;
    private $regionManager;
    private $localisationManager;
    private $clientManager;    

    public function __construct() {
        $this->villeManager = new VilleManager();
        $this->departementManager = new DepartementManager();
        $this->regionManager = new RegionManager();
        $this->localisationManager = new LocalisationManager();
        $this->clientManager = new ClientManager();
    }

    public function showContactForm($success = false) {

        $success = isset($_GET['success']) ? (bool) $_GET['success'] : false;
        // Récupération des villes
        $villes = $this->villeManager->getVilles();
        $departements = $this->departementManager->getDepartements();
        $regions = $this->regionManager->getRegions();
        $clients = $this->clientManager->getClientsWithContacts();
        $localisations = $this->localisationManager->getLocalisations();
        
        $view = new View();
        $view->render('newContactForm', [
            'villes' => $villes,
            'departements' =>$departements,
            'regions' => $regions,
            'localisations' => $localisations,
            'clients' => $clients,
            'success' => $success,
        ]);
    }
}

