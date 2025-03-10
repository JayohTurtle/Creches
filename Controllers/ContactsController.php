<?php

class ContactsController {
    public function showContacts() {
        // Récupérer les données traitées après la redirection
        $contact = $_SESSION['contact'] ?? null;  // Par exemple, tu peux utiliser une session ou une autre méthode pour passer les données
        $commentaires = $_SESSION['commentaires'] ?? null;
        $localisations = $_SESSION['localisations'] ?? null;

        // Rendre la vue avec les données
        $view = new View();
        $view->render('researchResultContacts', [
            'contact' => $contact,
            'commentaires' => $commentaires,
            'localisations' => $localisations,
        ]);
    }
}
