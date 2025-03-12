<?php

class ResultInteretGroupeController {
    private $interetGroupeManager;
    private $interetCrecheManager;

    public function __construct() {
        $this->interetGroupeManager = new InteretGroupeManager();
        $this->interetCrecheManager = new InteretCrecheManager();

    }

    public function showResultInteretGroupe(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $groupe = $this->sanitizeInput($_POST['groupe']);

            // Récupérer les contacts intéressés par le groupe
            $contacts = $this->interetGroupeManager->getContactsByGroupe($groupe);

            // Ajouter le nombre de crèches
            foreach ($contacts as $contact) {
                // Ajouter le nombre de crèches pour chaque contact
                $nbCreches = $this->interetCrecheManager->getNbCrechesByContactId($contact->getIdContact());
                $contact->setNbCreches($nbCreches);
            }

            $view = new View();
            $view->render('researchResultInteretGroupe', [
                'contacts' => $contacts,
                'groupe' => $groupe,
            ]);
        }
    }

   /**
    * Fonction utilitaire pour nettoyer les entrées utilisateur.
    */
    private function sanitizeInput($input) {
        if (is_array($input)) {
            return array_map([$this, 'sanitizeInput'], $input); // Nettoie les entrées dans les tableaux
        }
        return trim($input); // Supprime simplement les espaces inutiles
    }
}