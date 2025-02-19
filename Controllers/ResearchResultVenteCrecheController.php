<?php

class ResearchResultVenteCrecheController{

    private $interetVilleManager;
    private $localisationManager;
    private $contactManager;

    public function __construct() {
        $this->interetVilleManager = new InteretVilleManager();
        $this->localisationManager = new LocalisationManager();
        $this->contactManager = new ContactManager();
    }

    public function showResultVenteCreche() {
        $ville = '';
        $identifiants = [];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $postData = $_POST;

            $ville = $this->sanitizeInput($postData['zoneVille']);
            
            // Récupérer idVille avec le nom de la ville
            $idVille = $this->interetVilleManager->getIdVilleByName($ville);
    
            // Récupérer les idContact avec idVille
            $contacts = $this->localisationManager->getContactsByIdVille($idVille);
            
            // Récupérer les vendeurs avec les idContact récupérés
            $vendeurs = $this->contactManager->getVendeurContactsByIdContacts($contacts);

            // Extraire les ID des vendeurs
            $idVendeurs = array_map(fn($v) => $v->getIdContact(), $vendeurs);
    
            // Récupérer les objets Localisation contenant les identifiants
            $localisations = $this->localisationManager->getLocalisationsByVendeurAndVille($idVendeurs, $idVille);

            $identifiants = [];
            foreach ($localisations as $localisation) {
                $identifiants[] = $localisation->getIdentifiant();
            }

        $view = new View();
        $view->render('researchResultZoneVente', [
            'identifiants' => $localisations,
            'ville'=>$ville
        ]);
    }
}

    /**
     * Fonction utilitaire pour nettoyer les entrées utilisateur.
     */
    private function sanitizeInput($input) {
        if (is_array($input)) {
            return array_map([$this, 'sanitizeInput'], $input);
        }
        return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
    }
}