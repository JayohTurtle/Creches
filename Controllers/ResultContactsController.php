<?php

class ResultContactsController {

    public function showResultContacts() {
        // Récupérer les données traitées après la redirection
        $contact = $_SESSION['contact'] ?? null; 
        $commentaires = $_SESSION['commentaires'] ?? null;
        $localisations = $_SESSION['localisations'] ?? null;

        // Rendre la vue avec les données
        $view = new View();
        $view->render('researchContacts', [
            'contact' => $contact,
            'commentaires' => $commentaires,
            'localisations' => $localisations,
        ]);
    }
}