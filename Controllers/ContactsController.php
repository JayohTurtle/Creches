<?php

class ContactsController {
    private $contactManager;
    private $localisationManager;
    private $clientManager;
    private $villeManager;
    private $departementManager;
    private $regionManager;

    public function __construct() {
        $this->contactManager = new ContactManager();
        $this->localisationManager = new LocalisationManager();
        $this->clientManager = new ClientManager();
        $this->villeManager = new VilleManager();
        $this->departementManager = new DepartementManager();
        $this->regionManager = new RegionManager();
    }

    public function showContacts() {
        $contacts = $this->contactManager->getContacts();
        $localisations = $this->localisationManager->getLocalisations();
        $clients = $this->clientManager->getClientsWithContacts();
        $villes = $this->villeManager->getVilles();
        $departements = $this->departementManager->getDepartements();
        $regions = $this->regionManager->getRegions();
        $clientsList = $this->clientManager->getAllClients();

        $view = new View();
        $view -> render('contacts', [
            'contacts' => $contacts,
            'localisations' => $localisations,
            'clients' => $clients,
            'villes' => $villes,
            'departements' => $departements,
            'regions' => $regions,
            'clientList' => $clientsList,
        ]);
    }
}
