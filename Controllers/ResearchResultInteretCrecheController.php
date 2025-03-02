<?php

class ResearchResultInteretCrecheController {
    private $interetCrecheManager;
    private $departementManager;
    private $villeManager;

    public function __construct() {
        $this->interetCrecheManager = new InteretCrecheManager();
        $this->departementManager = new DepartementManager();
        $this->villeManager = new VilleManager();
    }
    
    public function showResultInteretCreche() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $identifiant = $this-> sanitizeInput($_POST['identifiant']);
    
            // Récupérer les contacts intéressés par la crèche
            $contacts = $this->interetCrecheManager->getContactsByIdentifiant($identifiant);

            //récupérer l'id de la ville
            $idVille = $this->villeManager->getVilleIdByIdentifiant($identifiant);
            //récupérer le nom de la ville
            $ville = $this->villeManager->getVilleNameById($idVille);

            // Récupérer l'ID du département de la crèche
            $idDepartement = $this->departementManager->getDepartementIdByIdentifiant($identifiant);
            // Récupérer le nom du département
            $departement = $this->departementManager->getDepartementNameById($idDepartement);

            // Ajouter le nombre de crèches et vérifier l'intérêt pour le département
            foreach ($contacts as $contact) {
                // Ajouter le nombre de crèches pour chaque contact
                $nbCreches = $this->interetCrecheManager->getNbCrechesByContactId($contact->getIdContact());
                $contact->setNbCreches($nbCreches);

                $isInterestedInDepartment = $this->interetCrecheManager->isContactInterestedInDepartment($contact->getIdContact(), $idDepartement);

                if ($isInterestedInDepartment) {
                    $departementObj = new Departement();
                    $departementObj->setDepartement($departement);  // Stocker le nom du département
                    $contact->setDepartement($departementObj);
                } else {
                    $contact->setDepartement(null);
                }

                $isInterestInCity = $this->interetCrecheManager->isContactInterestedInCity($contact->getIdContact(), $idVille);
                if ($isInterestInCity) {
                    $villeObj = new Ville();
                    $villeObj->setVille($ville);  // Stocker le nom du département
                    $contact->setVille($villeObj);
                } else {
                    $contact->setVille(null);
                }
            }
            // Passer les données à la vue
            $view = new View();
            $view->render('researchResultInteretCreche', [
                'contacts' => $contacts,
                'identifiant' => $identifiant,
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

    

