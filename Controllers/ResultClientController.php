<?php

class ResultClientController{

    private $contactManager;
    private $commentManager;
    private $localisationManager;
    private $clientManager;
    private $interetCrecheManager;
    private $interetGroupeManager;

    public function __construct() {
        $this->contactManager = new ContactManager();
        $this->commentManager = new CommentManager();
        $this->localisationManager = new LocalisationManager();
        $this->clientManager = new ClientManager();
        $this->interetCrecheManager = new InteretCrecheManager();
        $this->interetGroupeManager = new InteretGroupeManager();
    }

    public function handleResearchClient(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $postData = $_POST;

        }// Liste des champs à vérifier
        $donnees = [
            'contact' => $this->sanitizeInput($postData['donneeContact'] ?? ''),
            'nom' => $this->sanitizeInput($postData['donneeNomGroupe'] ?? ''),
            'email' => $this->sanitizeInput($postData['donneeEmail'] ?? ''),
            'siren' => $this->sanitizeInput($postData['donneeSIREN'] ?? ''),
            'telephone' => $this->sanitizeInput($postData['donneeTelephone'] ?? ''),
            'siteInternet' => $this->sanitizeInput($postData['donneeSiteInternet'] ?? ''),
        ];
    
        $donneeRecherchee = null;
        $valeurRecherchee = null;
    
        // Trouver la première valeur non vide
        foreach ($donnees as $champ => $valeur) {
            if (!empty($valeur)) {
                $donneeRecherchee = $champ; 
                $valeurRecherchee = $valeur;
                
                break; // On s'arrête après avoir trouvé la première donnée remplie
            }
        }
    
        $localisations = null;
    
        if ($valeurRecherchee !== null && $donneeRecherchee !== null) {
            // Récupérer l'objet client
            $client = $this->contactManager->extractResearchClient($donneeRecherchee, $valeurRecherchee);
        
            if ($client && method_exists($client, 'getIdContact')) {
                // Récupérer l'ID du client depuis l'objet Contact
                $idClient = $client->getIdContact();
                
                // Récupérer les localisations du client
                $localisations = $this->localisationManager->getLocalisationByContact($idClient);
                $adresses = array_map(fn($loc) => $loc->getAdresse(), $localisations);
            }
        }
        

        $clientData = $this->clientManager->getDataClientsById($idClient);

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
