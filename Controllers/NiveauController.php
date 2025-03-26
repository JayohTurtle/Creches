<?php

class NiveauController{

    private $interetCrecheManager;

    public function __construct() {
        $this->interetCrecheManager = new InteretCrecheManager();
    }

    public function showNiveau() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $niveau = $_POST['niveau'];
        }
            $contacts = $this->interetCrecheManager->getContactsByNiveau($niveau);

            // Passer les résultats à la vue
            $view = new View();
            $view->render('seeNiveaux', [
            'niveau'=> $niveau,
            'contacts'=> $contacts,
        ]);
    }
}