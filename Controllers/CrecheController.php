<?php

class CrecheController {
    private $contactManager;
    private $localisationManager;
    private $clientManager;
    private $villeManager;
    private $departementManager;
    private $regionManager;
    private $interetCrecheManager;

    public function __construct() {
        $this->contactManager = new ContactManager();
        $this->localisationManager = new LocalisationManager();
        $this->clientManager = new ClientManager();
        $this->villeManager = new VilleManager();
        $this->departementManager = new DepartementManager();
        $this->regionManager = new RegionManager();
        $this->interetCrecheManager = new InteretCrecheManager();
    }

    public function handleCreche() {
        $contacts = $this->contactManager->getAcheteursContacts();
        $localisations = $this->localisationManager->getLocalisations();
        $villes = $this->villeManager->getVilles();
        $departements = $this->departementManager->getDepartements();
        $regions = $this->regionManager->getRegions();
    }
}