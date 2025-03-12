<?php

class InteretCrecheController {
    private $interetCrecheManager;
    private $localisationManager;
    private $contactManager;
    private $clientManager;

    public function __construct() {
        $this->interetCrecheManager = new InteretCrecheManager();
        $this->localisationManager = new LocalisationManager();
        $this->contactManager = new ContactManager();
        $this->clientManager = new ClientManager();
    }
    
    public function showInteretCreche() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $idLocalisation = $_POST['idLocalisation'];

            $localisation = $this->localisationManager->getLocalisationByIdLocalisation($idLocalisation);
            
            $idContact = $localisation->getIdContact();

            $nombreCreches = $this->localisationManager->countCreches($idContact);

            $interetsCreche = $this->interetCrecheManager->getInteretsCrecheByIdLocalisations([$idLocalisation]);

        }

        // Passer les résultats à la vue
        $view = new View();
        $view->render('interetsCreche', [
            'interetsCreche' => $interetsCreche,
            'localisation' => $localisation,
            'nombreCreches' =>$nombreCreches,
        ]);
    }
}