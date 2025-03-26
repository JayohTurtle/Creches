<?php

class ContactsController {
    private $contactManager;
    private $localisationManager;
    private $villeManager;
    private $departementManager;
    private $regionManager;

    public function __construct(){
        $this->contactManager = new ContactManager();
        $this->localisationManager = new LocalisationManager();
        $this->villeManager = new VilleManager();
        $this->departementManager = new DepartementManager();
        $this->regionManager = new RegionManager();
    }

    public function showContacts() {
        $contacts = $this->contactManager->getContacts();
        $localisations = $this->localisationManager->getLocalisations();
        $departements = $this->departementManager->getDepartements();
        $regions = $this->regionManager->getRegions();
        $villes = $this->villeManager->getVilles();

        // Passer toutes les données à la vue
        $view = new View();
        $view->render('contacts', [
            'contacts' => $contacts,
            'localisations' => $localisations,
            'villes' => $villes,
            'departements' => $departements,
            'regions' => $regions,

        ]);
    }
}
