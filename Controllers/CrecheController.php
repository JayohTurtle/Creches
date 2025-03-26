<?php

class CrecheController {
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

    public function showCreche() {
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $idLocalisation = $_GET['idLocalisation'];

            $localisation = $this->localisationManager->getLocalisationByidLocalisation($idLocalisation);

        }

        // Passer toutes les données à la vue
        $view = new View();
        $view->render('creche', [
            'localisation' => $localisation
        ]);
    }
}